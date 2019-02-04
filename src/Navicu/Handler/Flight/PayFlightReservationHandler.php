<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightPayment;
use App\Entity\FlightReservation;
use App\Entity\PaymentType;
use App\Entity\CurrencyType;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\AirlineService;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\PaymentGatewayService;

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

        if (! $this->processPayments($reservation, $params['payments'], $params['paymentType'])) {
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
            'publicId' => 'required',
            'paymentType' => 'required|numeric|between:1,3',
            'payments' => 'required'
        ];
    }

    /**
     * Procesa el pago por el monto indicado
     *
     * @param FlightReservation $reservation
     * @param array $payments
     * @param int $paymentType
     * @return bool
     * @throws NavicuException
     */
    private function processPayments(FlightReservation $reservation, array $payments, int $paymentType) : bool
    {

        $manager = $this->container->get('doctrine')->getManager();
        $paymentGateway = PaymentGatewayService::getPaymentGateway($paymentType);

        $flight_reservation_gds = $reservation->getGdsReservations();
        $currency = $flight_reservation_gds[0]->getCurrencyReservation()->getAlfa3();
        
        // Stripe
        if ($paymentType === 2) {
            $paymentGateway->setZeroDEcimalBase($manager->getRepository(CurrencyType::class)->findOneby(['alfa3'=>$currency])->getZeroDecimalBase());
            $paymentGateway->setCurrency($currency);         
        }

        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();

        foreach ($payments as $i => $payment) {
            $payments[$i]['description'] = 'Pago de reserva ' . $reservation->getPublicId();
            $payments[$i]['expirationDate'] = $payment['expirationMonth'] . '/' . $payment['expirationYear'];
            $payments[$i]['ip'] = $ip;
            $payments[$i]['date'] = \Date('d-m-Y');
        }

        $responsePayments = $paymentGateway->processPayments($payments);

        foreach ($responsePayments as $payment) {

            $flightPayment = new FlightPayment();

            $v_code = $payment['id'] ?? $payment['code'];
            $v_amount = $payment['amount'] ?? 0;
            $holderId = $payment['holderId'] ?? null;

            if (isset($payment['fase'])) {
                $request = $payment['request'];
                $status = $payment['fase'] === 2 ? $payment['status'] : 3;
            } else {
                $status = $payment['status'];
                $request = null;
            }

            /** @var PaymentType $paymentTypeInstance */
            $paymentTypeInstance = $manager->getRepository(PaymentType::class)->find($paymentGateway->getTypePayment());

            $flightPayment
                ->setCode($v_code)
                ->setDate(new \DateTime())
                ->setReference($payment['reference'])
                ->setAmount($v_amount)
                ->setFlightReservation($reservation)
                ->setIpAddress($ip)
                ->setHolder($payment['holder'])
                ->setHolderId($holderId)
                ->setState($status)
                ->setType($paymentType)
                ->setPaymentType($paymentTypeInstance)
                ->setPaymentCommision($paymentTypeInstance->getCommision())
                ->setResponse($payment['response']);

            if ($request) {
                $flightPayment->setRequest(json_encode($request)); // TODO encrypt
            }

            $reservation->addPayment($flightPayment);

            $manager->persist($flightPayment);
            $manager->flush();
        }

        if (! $paymentGateway->isSuccess()) {
            throw new NavicuException('Payment fail');
        }

        return true;
    }
}