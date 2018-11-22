<?php

namespace App\Navicu\PaymentGateway;

class StripePaymentGateway 
{
    /**
     * @var string The Payeezy API params to be used for requests.
     */
    public static $apiKey;
    public static $apiSecret;
    public static $merchantToken;
    public static $baseURL;
    public static $tokenURL;
    public static $url;

    /**
     * indica la moneda de la operacion
     */
    private $currency;
    /**
     * indica el estado de la transacción tras un evento de pago
     */
    private $success;

    private $statusId = 1;

    private $zeroDecimalBase;

    private $rf;

    private $logger;

    private  $authorization;

    private $nonce;

    public $timestamp;
}  