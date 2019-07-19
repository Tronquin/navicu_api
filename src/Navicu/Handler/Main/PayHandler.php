<?php

namespace App\Navicu\Handler\Main;

use App\Entity\CurrencyType;
use App\Navicu\Contract\PaymentGateway;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\PaymentGatewayService;

/**
 * Procesa un pago por el medio correspondiente
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class PayHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $paymentGateway = PaymentGatewayService::getPaymentGateway($params['paymentType']);

        if (method_exists($paymentGateway, 'setCurrency')) {
            $paymentGateway->setCurrency($params['currency']);
        }

        $payments = $this->completePaymentInfo($params['payments']);
        $responsePayments = $paymentGateway->processPayments($payments);

        foreach ($responsePayments as $payment) {

            if (!$payment['success']) {
                throw new NavicuException('Payment fail', BaseHandler::CODE_EXCEPTION, $payment['paymentError']);
            }
        }

        return compact('responsePayments');
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
    protected function validationRules() : array
    {
        return [
            'paymentType' => 'required|numeric|between:1,8',
            'currency' => 'required|regex:/^[A-Z]{3}$/',
            'payments' => 'required'
        ];
    }

    /**
     * Estandariza el request sin importa el medio de pago
     *
     * @param array $payments
     * @return array
     */
    private function completePaymentInfo(array $payments)
    {
        $response = [];
        $totalToPay = 0;

        foreach ($payments as $payment) {

            $payment['amount'] = str_replace(',', '.', (string)$payment['amount']);
            $amount = number_format($payment['amount'], 2);
            $totalToPay += $payment['amount'];

            $response[] = array_merge(
                $payment,
                [
                    'description' => 'Pago de la compra',
                    'ip' => $this->container->get('request_stack')->getCurrentRequest()->getClientIp(),
                    'amount' => $amount,
                    'date' => \date('d-m-Y'),
                    'expirationDate' => isset($payment['expirationMonth'])? $payment['expirationMonth'] . '/' . $payment['expirationYear'] : null,
                    'number' => isset($payment['number']) ? $payment['number'] : null ,
                ]
            );
        }

        return $response;
    }
}