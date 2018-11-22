<?php

namespace App\Navicu\Service;
use App\Entity\Airline;
use App\Entity\AirlineFinancialTransaction;
use App\Entity\CurrencyType;
use App\Entity\FlightReservation;

/**
 * Servicio para realizar los movimientos en el
 * credito de la aerolinea
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class AirlineService
{
    /**
     * Función usada para almacenar un movimiento financiero
     * de una Aerolinea dado un conjunto de datos.
     *
     * @param array $data
     * @param Airline $airline
     * @return AirlineFinancialTransaction
     */
    public static function setMovement(array $data, Airline $airline) : AirlineFinancialTransaction
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        $financialTransaction = new AirlineFinancialTransaction();
        $financialTransaction->updateObject($data);
        $financialTransaction->setAirline($airline);

        $manager->persist($financialTransaction);
        $manager->flush();

        return $financialTransaction;
    }

    /**
     * Genera los movimientos financieros para una reservacion
     *
     * @param FlightReservation $reservation
     * @param string $sign
     */
    public static function setMovementFromReservation(FlightReservation $reservation, string $sign)
    {
        foreach ($reservation->getGdsReservations() as $gdsReservation) {

            $airline = $gdsReservation->getAirlineProvider();
            $currency = $gdsReservation->getCurrencyGds();

            $invoiceAmount = $gdsReservation->getSubtotalOriginal();

            $data = [];
            $data['description'] = 'Reservacion ' . $reservation->getPublicId();
            $data['amount'] = $invoiceAmount;
            $data['sign'] = $sign;
            $data['type'] = 1;
            $data['status'] = true;
            $data['date'] = $reservation->getReservationDate();
            $data['currency'] = $currency;

            // Por cada vuelo registro el movimiento
            self::setMovement($data, $airline);
            // Aplica el movimiento en el balance de la cuenta
            self::balanceCalculator($airline, $currency->getAlfa3());
        }
    }

    /**
     * Función usada para calcular el balance de una Aerolinea
     *
     * @param Airline $airline
     * @param string $alpha3
     * @return bool
     */
    public static function balanceCalculator(Airline $airline, string $alpha3)
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        if (! $airline || ! $airline->getFinancialTransactions()) {
            return false;
        }

        $invoiceAmount = 0;
        foreach ($airline->getFinancialTransactions() as $transaction) {

            // Consulta si la moneda de la reserva del vuelo es local (Bolivares)
            if (CurrencyType::isLocalCurrency($alpha3)) {

                // si la moneda de la transaccion es local (Bolivares)
                if (CurrencyType::isLocalCurrency($transaction->getCurrency()->getAlfa3())) {

                    // Si la moneda de la transaccion es diferenete a la moneda actual activa (VES), operamos el monto
                    if ($transaction->getCurrency()->getAlfa3() !== CurrencyType::getLocalActiveCurrency()->getAlfa3()){
                        $invoiceAmount += ($transaction->getSignNumber() * $transaction->getAmount())/CurrencyType::getRateReconversion();
                    } else {
                        $invoiceAmount += ($transaction->getSignNumber() * $transaction->getAmount());
                    }
                }

            } else {
                // Si la moneda no es local

                if ($transaction->getCurrency()->getAlfa3() === $alpha3) {
                    $invoiceAmount += ($transaction->getSignNumber() * $transaction->getAmount());
                }
            }
        }

        if (CurrencyType::isLocalCurrency($alpha3)) {
            $airline->setCreditAvailable($airline->getCreditInitial() + $invoiceAmount);
        } else {
            $airline->setInternationalCreditAvailable($airline->getInternationalCreditInitial() + $invoiceAmount);
        }

        $manager->flush();

        return true;
    }
}