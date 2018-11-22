<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightPayment;
use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\AirlineService;
use App\Navicu\Service\ConsolidatorService;

class PayFlightReservationHandler extends BaseHandler
{
    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        $reservationTotal = 0;
        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            // Calcula el monto a pagar por toda la reservacion
            $reservationTotal += $gdsReservation->getTotal();
        }

        $paymentTotal = 0;
        foreach ($reservation->getPayments() as $payment) {
            // Calcula el monto pagado por la reserva
            $paymentTotal += $payment->getAmount();
        }

        if ($paymentTotal >= $reservationTotal) {
            // Indica que la reserva esta paga, detengo el proceso para no repetir el cobro
            return compact('reservation');
        }

        if (! $this->processPayment($reservationTotal)) {
            throw new NavicuException('Payment fail');
        }

        // Movimientos en los creditos de aerolinea y consolidador
        ConsolidatorService::setMovementFromReservation($reservation);
        AirlineService::setMovementFromReservation($reservation, '-');

        $manager->flush();

        return compact('reservation');
    }

    /**
     * Todas las reglas de validacion para los parametros que recibe
     * el Handler
     *
     * Las reglas de validacion estan definidas en:
     * @see \App\Navicu\Service\NavicuValidator
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'publicId' => 'required'
        ];
    }

    /**
     * Procesa el pago por el monto indicado
     *
     * @param float $amount
     * @return bool
     */
    private function processPayment(float $amount) : bool
    {
        // TODO Servicio de pago y guardar FlightPayment
        /*$paymentType = $rfPaymentType->findById($pgw->getTypePayment());
        $payment = new FlightPayment();

        $payment
            ->setCode($v_code)
            ->setDate(new \DateTime())
            ->setReference($payment['reference'])
            ->setAmount($v_amount)
            ->setReservation($reservation)
            ->setIpAddress($this->command->get('ip'))
            ->setHolder($payment['holder'])
            ->setHolderId((isset($payment['holderId']) ? $payment['holderId'] : null))
            ->setState($status)
            ->setType($pgw->getTypePayment())
            ->setPaymentType($paymentType)
            ->setPaymentCommision($paymentType->getCommision())
            ->setRequest($kernel->getContainer()->get('SecurityService')->my_encrypt_key(json_encode($request)))
            ->setResponse($payment['response']);

        $reservation->addPayment($payment);
        $data[] = $payment;*/

        return true;
    }
}