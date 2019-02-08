<?php
namespace App\Navicu\Service;

use App\Navicu\PaymentGateway\InstapagoPaymentGateway;
use App\Navicu\PaymentGateway\PayeezyPaymentGateway;
use App\Navicu\PaymentGateway\PaypalPaymentGateway;
use App\Navicu\PaymentGateway\StripePaymentGateway;
use App\Navicu\Contract\PaymentGateway;
use App\Navicu\Exception\NavicuException;
use Symfony\Component\Dotenv\Dotenv;
use Psr\Log\LoggerInterface;

class PaymentGatewayService
{

    private $container;

    /**
     * Obtiene la implementacion del PaymentGateway acorde a la pasarela
     * de pago a utilizar
     *
    * @author Javier Vasquez <jvasquez@jacidi.com>

     * @param int $type
     * @return PaymentGateway
     * @throws NavicuException
     */
    public static function getPaymentGateway(int $type) : PaymentGateway
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        if ($type === PaymentGateway::INSTAPAGO_TDC) {                   
            $config['public_id'] = getenv('INSTAPAGO_PUBLIC_ID');
            $config['private_id'] = getenv('INSTAPAGO_PRIVATE_ID');
            $config['url_payment_petition'] = getenv('INSTAPAGO_URL_PAYMENT');
            $paymenGateway = new InstapagoPaymentGateway($config);      

        } elseif ($type === PaymentGateway::STRIPE_TDC) {
            $config['api_key'] = getenv('STRIPE_API_KEY');
            $paymenGateway = new StripePaymentGateway($config);

        } elseif($type === PaymentGateway::PAYEEZY) {
            $config['api_key'] = getenv('PAYEEZY_API_KEY');
            $config['api_secret'] = getenv('PAYEEZY_API_SECRET');
            $config['merchant_token'] = getenv('PAYEEZY_MERCHANT_TOKEN');
            $config['base_url'] = getenv('PAYEEZY_BASEURL');
            $config['url'] = getenv('PAYEEZY_URL');
            $paymenGateway = new PayeezyPaymentGateway($config);

        } elseif ($type === PaymentGateway::PAYPAL) {
            $paymenGateway = new PaypalPaymentGateway();

        } else {
            throw new NavicuException('Payment Type Undefined');
        }
        return $paymenGateway;
    }
} 