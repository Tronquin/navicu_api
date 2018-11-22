<?php
namespace App\Navicu\Service;

use App\Navicu\PaymentGateway\BanescoTDCPaymentGateway;
use App\Navicu\PaymentGateway\PayeezyPaymentGateway;
use App\Navicu\Resources\PaymentGateway\StripeTDCPaymentGateway;
use App\Navicu\Contract\PaymentGateway;
use App\Navicu\Exception\NavicuException;

class PaymentGatewayService
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getPaymentGateway($type)
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        if ($type==PaymentGateway::BANESCO_TDC) {
            //pago con TDC            
            $config['public_id'] = getenv('instapago_public_id');
            $config['private_id'] = getenv('instapago_private_id');
            $config['url_payment_petition'] = getenv('instapago_url_payment_petition');
            $paymenGateway = new InstapagoPaymentGateway($config);
        /*} elseif ($type==PaymentGateway::NATIONAL_TRANSFER) {
            //Pago por transferencia bancaria nacional
            $paymenGateway = new BanckTransferPaymentGateway();
        */} elseif ($type==PaymentGateway::STRIPE_TDC) {
            //Pago por TDC en moneda extranjera
            $paymenGateway = new StripeTDCPaymentGateway();
        /*} elseif ($type==PaymentGateway::INTERNATIONAL_TRANSFER) {
            //Pago por Transferencia en moneda extranjera
            $paymenGateway = new InternationalBanckTransferPaymentGateway();
        } else if ($type == PaymentGateway::AAVV) {
            //Pago por agencia de viaje
            $paymenGateway = new AAVVPaymentGateway();
        */} else if($type == PaymentGateway::PAYEEZY){
            $paymenGateway = new PayeezyPaymentGateway();
        /*} else if($type == PaymentGateway::PANDCO_TRANSFER){
            //Pago por pandco
            $paymenGateway = new PandcoTransferPaymentGateway();
          } else if($type == PaymentGateway::Paypal ){
            //Pago por Paypal
            $paymenGateway = new PaypalpaymentGateway();
       */} else {
            throw new NavicuException('Payment Type Undefined');
        }
        return $paymenGateway;
    }
} 