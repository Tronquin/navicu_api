<?php

namespace App\Navicu\Service;
use App\Entity\Consolidator;
use App\Entity\ConsolidatorTransaction;
use App\Entity\CurrencyType;
use App\Entity\FlightReservation;

/**
 * Genera los movimientos en el credito del consolidador
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ConsolidatorService
{
    /**
     * Función usada para generar un movimiento
     *
     * @param $amount
     * @param $description
     * @param $consolidatorId
     * @return bool
     */
    public static function setMovement($amount, $description, $consolidatorId) : bool
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        $consolidator = $manager->getRepository(Consolidator::class)->find($consolidatorId);

        if (! $consolidator) {
            return false;
        }

        $invoiceAmount = $consolidator->getCreditAvailable() + $amount;
        // No aplica el movimiento ni crea la transaccion
        if ($invoiceAmount < 0 || $invoiceAmount > $consolidator->getCredit()) {
            return false;
        }
        $financialTransaction = new ConsolidatorTransaction();
        $financialTransaction->setAmount($amount);
        $financialTransaction->setDescription($description);
        $financialTransaction->setDate(new \DateTime());
        $financialTransaction->setConsolidator($consolidator);
        $financialTransaction->setCurrency($consolidator->getCurrency());

        $manager->persist($financialTransaction);
        $manager->flush();

        // Aplica el movimiento en el balance de la cuenta
        return self::balanceCalculator($consolidator);
    }

    /**
     * Genera los movimientos del Consolidador para una reservacion
     *
     * @param FlightReservation $reservation
     * @return bool
     */
    public static function setMovementFromReservation(FlightReservation $reservation) : bool
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        /** @var Consolidator $consolidator */
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();

        if (! $consolidator) {
            return false;
        }

        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            if ($gdsReservation->isAmadeus()) {

                $amount = $gdsReservation->getSubtotalOriginal();
                $increment = $gdsReservation->getIncrementConsolidator();
                $activeCurrency = CurrencyType::getLocalActiveCurrency();

                $increment = NavicuCurrencyConverter::convert(
                    $increment,
                    $activeCurrency->getAlfa3(),
                    NavicuCurrencyConverter::CURRENCY_DOLLAR
                );

                $amount = $amount + $increment;

                if ($amount > 0) {
                    self::setMovement($amount * -1, 'Reservacion ' . $reservation->getPublicId(), $consolidator->getId());
                }
            }
        }

        return true;
    }

    /**
     * Función usada para calcular el balance de un Consolidador
     *
     * @param Consolidator $consolidator
     * @return bool
     */
    public static function balanceCalculator(Consolidator $consolidator) : bool
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        $consolidatorTransactions = $consolidator->getConsolidatorTransactions();

        if (! $consolidator || ! $consolidatorTransactions)
            return false;

        $invoiceAmount = 0;
        foreach ($consolidatorTransactions as $transaction) {
            $invoiceAmount += $transaction->getAmount();
        }

        if ($invoiceAmount < 0 || $invoiceAmount > $consolidator->getCredit()) {
            return false;
        }

        $consolidator->setCreditAvailable($invoiceAmount);
        $manager->flush();

        if ($consolidator->getCreditAvailable() <= $consolidator->getCreditWarning()) {
            // Notifica credito casi agotado
            self::sendBalanceNotification($consolidator);
        }

        return true;
    }

    /**
     * Verifica si hay credito suficiente para una reservacion
     *
     * @param FlightReservation $reservation
     * @return bool
     */
    public static function hasCreditForReservation(FlightReservation $reservation) : bool
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        /** @var Consolidator $consolidator */
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();

        if (! $consolidator) {
            return false;
        }

        $total = 0;
        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            if ($gdsReservation->isAmadeus()) {

                $amount = $gdsReservation->getSubtotalOriginal();
                $increment = $gdsReservation->getIncrementConsolidator();
                $activeCurrency = CurrencyType::getLocalActiveCurrency();

                $increment = NavicuCurrencyConverter::convert(
                    $increment,
                    $activeCurrency->getAlfa3(),
                    NavicuCurrencyConverter::CURRENCY_DOLLAR
                );

                $amount = $amount + $increment;

                $total += $amount;
            }
        }

        if ($total > $consolidator->getCreditAvailable()) {
            return false;
        }

        return true;
    }

    /**
     * Indica si el consolidador tiene credito suficiente para manejar
     * monto indicado
     *
     * @param $amount
     * @return bool
     */
    public static function hasCredit($amount)
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        /** @var Consolidator $consolidator */
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();

        if (! $consolidator || $amount > $consolidator->getCreditAvailable()) {
            return false;
        }

        return true;
    }

    /**
     * Calcula el incremento configurados en el consolidador
     *
     * @param $amount
     * @param bool $negotiatedRate
     * @return float
     */
    public static function calculateIncrement($amount, $negotiatedRate = false) : float
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        /** @var Consolidator $consolidator */
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();

        if (! $consolidator) {
            return 0;
        }

        $type = $negotiatedRate ? $consolidator->getIncrementTypeTarifaNeg() : $consolidator->getIncrementType();
        $increment = $negotiatedRate ? $consolidator->getIncrementTarifaNeg() : $consolidator->getIncrement();

        $incrementAmount = 0;

        if ($type === Consolidator::INCREMENT_TYPE_PERCENTAGE) {

            $incrementAmount = $amount * ($increment / 100);

        } elseif ($type === Consolidator::INCREMENT_TYPE_USD) {

            $incrementAmount = $increment;
        }

        return $incrementAmount;
    }

    /**
     * Envia un correo de notificacion cuando la venta no se pudo concretar
     * por no disponer de credito suficiente
     *
     * @param FlightReservation $reservation
     * @return bool
     */
    public static function sendSellIncompleteNotification(FlightReservation $reservation) : bool
    {
        EmailService::sendFromEmailRecipients(
            'consolidator_balance_notification',
            'Notificacion de venta no concretada - navicu.com',
            'Email:Flight/incompleteSellNotificationConsolidator.html.twig',
            compact('reservation')
        );

        return true;
    }

    /**
     * Envia un correo de notificacion de credito casi agotado
     *
     * @param Consolidator $consolidator
     * @return bool
     */
    private static function sendBalanceNotification(Consolidator $consolidator) : bool
    {
        EmailService::sendFromEmailRecipients(
          'consolidator_balance_notification',
          'Notificacion de credito casi agotado - navicu.com',
          'Email:Flight/balanceNotificationConsolidator.html.twig',
          compact('consolidator')
        );

        return true;
    }
}
