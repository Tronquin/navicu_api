<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightPayment;
use App\Entity\FlightReservation;
use App\Entity\PaymentType;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Handler\Main\PayHandler;
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
        $manager = $this->getDoctrine()->getManager();
        $params = $this->getParams();

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        $reservationTotal = 0;
        $currency = '';
        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            // Calcula el monto a pagar por toda la reservacion
            $reservationTotal += $gdsReservation->getTotal();
            $currency = $gdsReservation->getCurrencyReservation()->getAlfa3();
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

        // Procesa el pago por la paserela de pago
        $handler = new PayHandler();
        $handler->setParam('paymentType', $params['paymentType']);
        $handler->setParam('currency', $currency);
        $handler->setParam('payments', $params['payments']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {

            throw new NavicuException('Payment fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

        // Guarda el pago
        $this->savePayment($handler->getData()['data']['responsePayments'], $reservation);

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
            'paymentType' => 'required|numeric|between:1,8',
            'payments' => 'required'
        ];
    }

    /**
     * Guarda el pago
     *
     * @param array $payments
     * @param FlightReservation $reservation
     */
    private function savePayment($payments, FlightReservation $reservation)
    {
        $params = $this->getParams();
        $manager = $this->getDoctrine()->getManager();
        $paymentGateway = PaymentGatewayService::getPaymentGateway($params['paymentType']);
        $ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();

        foreach ($payments as $payment) {

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
                ->setType($params['paymentType'])
                ->setPaymentType($paymentTypeInstance)
                ->setPaymentCommision($paymentTypeInstance->getCommision())
                ->setResponse($payment['response'])
                ->setBank($payment['bank'] ?? null)
                ->setReceiverBank($payment['receiverBank'] ?? null)
            ;

            if ($request) {
                $flightPayment->setRequest(json_encode($request)); // TODO encrypt
            }

            $reservation->addPayment($flightPayment);

            $manager->persist($flightPayment);
            $manager->flush();
        }
    }
}