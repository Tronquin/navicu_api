<?php

namespace App\Navicu\PaymentGateway;

use App\Entity\CurrencyType;
use App\Entity\Reservation;
use App\Navicu\Contract\PaymentGateway;
use App\Navicu\Service\NavicuCurrencyConverter;

class PaypalPaymentGateway implements PaymentGateway
 {

    /**
     * define una antelación para este tipo de pago
     */
    const CUTOFF = 0;

    /**
     * indica si el pago se realizco con exito
     */
    private $success;


    /**
     * indica la moneda de la operacion
     */
    private $currency;

    /**
     * repósitory factory
     */
    private $rf;

    /** status de la transaction */
    private $statusId = 1;

    /**
     * este metodo toma un conjunto de pagos, los valida y los procesa
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     * @return  Object | json | array
     */

    public function processPayment($request)
    {

        $request = $this->formaterRequestData($request);
        $response = $this->formaterResponseData($request);
        $this->success = $this->success && $response['success'];
        return $response;
    }

    /**
     * este metodo toma un conjunto de pagos, los valida y los procesa
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     * @return  Object | json | array
     */
    public function processPayments($request)
    {
        $this->success = true;
        $response = [];
        foreach($request as $payment) {
            $response[] = $this->processPayment($payment);
        }
        return $response;

    }


    /**
     * debe devolver la data requerida para hacer la solicitud formateada segun los requerimientos de la entidad
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function formaterRequestData($request)
    {
        $amount = str_replace(",","",(string)$request['amount']);  //Eliminar las comas del monto a cobrar

        return array_merge(
            $request,
            [
                'amount' => $amount,
                'reference' => $request['payerID'],
                'holder' => null,
                'holderId' => null
            ]
        );
    }

    /**
     * debe devolver la data requerida para ser devuelta a el caso de uso segun el formato que necesite
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function formaterResponseData($response)
    {
        $np = NavicuCurrencyConverter::convert(
            $response['amount'],
            'USD',
            CurrencyType::getLocalActiveCurrency()->getAlfa3()
        );

        return array_merge($response,[
            'id' => null,
            'success' => true,
            'code' => '201',
            'status' => '0',
            'response' => null,
            'currency' => $this->currency,
            'dollarPrice' => $response['amount'],
            'nationalPrice' => $np,
            'responsecode' => 'success',
            'message' => 'success',
        ]);
    }

    /**
     * devueleve un entero que representa el estado de la reserva segun la condicion de los pagos
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function getStatusReservation(Reservation $reservation)
    {
        $status = 2; //confirmada

        return $status;
    }

    /**
     * indica si el pago es valido y correcto
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 18-03-2015
     */
    public function isSuccess()
    {
        return $this->success;
    }

    public function getTypePayment()
    {
        return PaymentGateway::PAYPAL;
    }

    public function getStates()
    {
        return [];
    }

    /**
     * Devuelve el status del la transacción
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * devuleve la antelacion por defecto para el tipo de pago
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 17-08-2016
     */
    public function getCutOff()
    {
        return self::CUTOFF;
    }

    /**
     * establece en que moneda se realizaran los cobros
     *
     * @param string $currency
     * @param RepositoryFactoryInterface $rf
     * @return Object
     */
    public function setCurrency($currency, RepositoryFactoryInterface $rf = null)
    {
        $this->currency = $currency;
        $this->rf = $rf;
    }


    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * debe validar que todos los campos requeridos para hacer la solicitud esten completos y sean correctos
     *
     */
    public function validateRequestData($request)
    {

    }
}