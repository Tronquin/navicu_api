<?php
namespace App\Navicu\Service;

use App\Navicu\PaymentGateway\InstapagoPaymentGateway;
use App\Navicu\PaymentGateway\PayeezyPaymentGateway;
use App\Navicu\PaymentGateway\StripePaymentGateway;
use App\Navicu\Contract\PaymentGateway;
use App\Navicu\Exception\NavicuException;
use Symfony\Component\Dotenv\Dotenv;
use Psr\Log\LoggerInterface;

class PaymentGatewayService
{

    private $container;

    public function getPaymentGateway($type)
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        if ($type === PaymentGateway::BANESCO_TDC) {
            //pago con TDC            
            $config['public_id'] = getenv('INSTAPAGO_PUBLIC_ID');
            $config['private_id'] = getenv('INSTAPAGO_PRIVATE_ID');
            $config['url_payment_petition'] = getenv('INSTAPAGO_URL_PAYMENT');
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