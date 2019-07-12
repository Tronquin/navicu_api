<?php
namespace App\Navicu\PaymentGateway;

use App\Navicu\Contract\PaymentGateway;
use App\Entity\CurrencyType;
use App\Navicu\Exception\NavicuException;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use App\Navicu\Service\NavicuCurrencyConverter;
use App\Navicu\Service\LogGenerator;

/**
* @author Javier Vasquez <jvasquez@jacidi.com>
*/

class StripePaymentGateway  extends BasePaymentGateway implements  PaymentGateway
{

    /**
     *  constante que define una antelación general para los PaymentGateway
     */
    const CUTOFF = 0;
    
    /**
     * indica el estado de la transacción tras un evento de pago
     */
    private  $success;

    /**
     * indica la moneda de la operacion
     */
    private $currency;

    /**
     * contiene los posibles estados de una reserva
     */
    private $states;

    private $rf;

    private $zeroDecimalBase;

    private $statusId = 1;

    public function __construct(array $config)
    {
        $this->config = $config;

        /*
         * Tipos de estados de la transacción
         *
         *  1: 'Hubo un error de comunicación con el banco, por favor intente mas tarde'
         *  2: 'La transacción ha sido rechazada por el banco, contacte a su entidad bancaria'
         *  3: 'Hubo un error de comunicación con el banco, por favor intente mas tarde'
         *  4: 'Su tarjeta se encuentra vencida'
         *  5: 'El código de seguridad indicado es invalido, por favor verifique e intente nuevamente'         *
         */
        $this->states = [
            'success' => 'APROBADO',
            'card_error' => 3,
            'rate_limit_error' => 2,
            'invalid_request_error' => 3,
            'authentication_error' => 3,
            'api_connection_error' => 2,
            'api_error' => 2,
        ];
        parent::__construct();
    }

    public function processPayment($request)
    {
        try {
        
            \Stripe\Stripe::setApiKey($this->config['api_key']);
            LogGenerator::saveStripe('Peticion Stripe:',json_encode($this->formaterRequestData($request)));
            

            $charge = \Stripe\Charge::create($this->formaterRequestData($request));
        
            LogGenerator::saveStripe('Respuesta Stripe:',json_encode($this->formaterResponseData($charge)));

            return $this->formaterResponseData($charge);
            

        } catch(\Stripe\Error\Base $e) {

            $body = $e->getJsonBody();
            $err  = $body['error'];
            $err['status'] = $e->getHttpStatus();
            $err['amount'] = $request['amount'];

            LogGenerator::saveStripe('Error Stripe:',json_encode( $this->formaterResponseErrorData($err,$request)));

            return $this->formaterResponseErrorData($err,$request);
        }
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
        $response = [];
        $this->success = false;
        foreach ($request as &$payment) {
            if ((isset($payment['date'])) && (!isset($payment['checkInDate'])))         
                $payment['checkInDate'] = $payment['date'];
            $currentResponse = $this->processPayment($payment);
            $response[] = $currentResponse;
        }

        if (isset($response[0]) && isset($response[0]['success'])) {
            $this->success = $response[0]['success'];
        }

        return $response;
    }

    /**
     * debe validar que todos los campos requeridos para hacer la solicitud esten completos y sean correctos
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     * @return  boolean
     */
    public function validateRequestData($request)
    {
        $amount = str_replace(",","",(string)$request['amount']);  //Eliminar las comas del monto a cobrar
        $amount = str_replace(".","",(string)$amount);  //Eliminar las comas del monto a cobrar

        if (empty($request['firstName']))
            throw new NavicuException(\get_class($this) . ': first_name_required');        
        if (empty($request['lastName']))
            throw new NavicuException(get_class($this) . ': last_name_required');
        if (empty($request['number']) || !$this->checkLuhn($request['number']))
            throw new NavicuException(get_class($this) . ': invalid_card_number');
        if(empty($request['expirationMonth']) || !is_numeric($request['expirationMonth']))
            throw new NavicuException(get_class($this) . ': invalid_month_expiration');
        if(empty($request['expirationYear']) || !is_numeric($request['expirationYear']))
            throw new NavicuException(get_class($this) . ': invalid_year_expiration');
        if(!$this->checkExpiredDate($request['expirationMonth'],$request['expirationYear']))
            throw new NavicuException(get_class($this) . ': invalid_date_expiration');
        if(empty($request['cvc']) || !is_numeric($request['cvc']) || strlen($request['cvc'])!=3)
            throw new NavicuException(get_class($this) . ': invalid_cvc');
        if(empty($request['amount']) || !is_numeric($amount))
            throw new NavicuException(get_class($this) . ': invalid_amount');
        if(empty($request['description']))
            throw new NavicuException(get_class($this) . ': invalid_description');
        if(empty($request['ip']))
            throw new NavicuException(get_class($this) . ': empty_ip');
        if(empty($request['checkInDate']) && !($request['checkInDate'] instanceof \DateTime))
            throw new NavicuException(get_class($this) . ': invalid_reservation_check_in');

        return true;
    }

    /**
     * debe devolver la data requerida para hacer la solicitud formateada segun los requerimientos de la entidad
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function formaterRequestData($request)
    {
       //new RateExteriorCalculator($this->rf,$this->currency,$request['checkInDate']);

        $amount = str_replace(",","",(string)$request['amount']); //Eliminar las comas del monto a cobrar
        //$amount = RateExteriorCalculator::calculateRateChange($amount); //cambia el monto a la moneda seleccionada
        $amount = (string)($amount*$this->zeroDecimalBase); //multiplica por la base zero decimal para convertirlo en su denominación mas baja
        $amount = str_replace(".","",(string)$amount); //Eliminar las comas del monto a cobrar

        return [
            "amount" => $amount,
            "currency" => $this->currency,
            "source" => $this->formatCardData($request),
            "description" => $request['description'],
            'metadata' => [
                'clientIp' => $request['ip'],
            ],
        ];
    }

    public function formatCardData($request)
    {
        $name = $request['holder'];
        return [
            'name' => $name,
            'number' => $request['number'],
            'exp_month' => $request['expirationMonth'],
            'exp_year' => $request['expirationYear'],
            'cvc' => $request['cvc'],
            'object' => 'card'
        ];
    }

    /**
     * debe devolver la data requerida para ser devuelta a el caso de uso segun el formato que necesite
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function formaterResponseData($response)
    {
        $dcharge = $response->__toJSON(); // Se pasa la respuesta de la API a Json para pasarla a json_decode
        $c_data = json_decode($dcharge,true);
        $np = NavicuCurrencyConverter::convert((((integer)$c_data['amount']) / $this->zeroDecimalBase), $this->currency, 'VES');

        return [
            'id' => $c_data['id'],
            'success' => $c_data['status'] == "succeeded",
            'code' => ($c_data['status'] == "succeeded") ? '201' : '400',
            'reference' => $c_data['id'],
            'status' => $c_data["status"] == 'succeeded' ? 1 : 2,
            'amount' => ((integer)$c_data['amount'])/$this->zeroDecimalBase, //devuelve el monto sin comas
            'response' => $dcharge,
            'currency' => $this->currency,
            'dollarPrice' => $c_data['amount'],          
            'nationalPrice' => $np,
            'responsecode' => 'success',
            'holder' => $response['source']['name'],
            'message' => 'success'
        ];
    }

    /**
     * debe devolver la data requerida para ser devuelta a el caso de uso segun el formato que necesite
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function formaterResponseErrorData($response, $request)
    {
        $national = str_replace(".",",",str_replace(",","",$response['amount']));
        //$foreign = RateExteriorCalculator::calculateRateChange($national);
        $foreign = NavicuCurrencyConverter::convert((((integer)$response['amount'])), 'VES', $this->currency);
        //new RateExteriorCalculator($this->rf,'USD');
        $dollar = NavicuCurrencyConverter::convert((((integer)$response['amount'])), 'VES', 'USD');
        $name = $request['holder'];

        return [
            'id' => null,
            'success' => false,
            'code' => $response['status'],
            'reference' => null,
            'status' => 2,
            'amount' => $foreign,
            'response' => json_encode($response),
            'currency' => $this->currency,
            'dollarPrice' => $dollar,
            'nationalPrice' => $national,
            'responsecode' => $response['type'],
            'holder' => $name,
            'message' => $response['message'],
            'paymentError' => self::getPaymentError($response)
        ];
    }

    private function getPaymentError($response) {

        $code = '99';
        $messages = ['No hemos podido establecer comunicación con el banco,', 'por favor intentalo más tarde'];

        if ($response['type'] === 'card_error') {
            if ($response['code'] === 'incorrect_number') {

                $code = '21';
                $messages = ['El número de tarjeta parece no estar correcto,','¡Intenta colocarlo de nuevo!'];

            } else if ($response['code'] === 'card_declined') {

                $code = '22';
                $messages = ['Lo sentimos, tu tarjeta ha sido rechazada,','Intenta con otra o realiza una transferencia bancaria'];

            } else if ($response['code'] === 'invalid_expiry_year') {

                $code = '23';
                $messages = ['La fecha de vencimiento de tu tarjeta no es correcta,','¡Verifica tus datos e intenta colocarla nuevamente!'];

            }else if($response['code'] === 'incorrect_cvc'){

                $code = '83';
                $messages = ['El código CVC parece no estar correcto,','¡Intenta colocarlo de nuevo!'];
                
            }else if($response['code'] === 'insufficient_funds'){

                $code = '51';
                $messages = ['La tarjeta que utilizas no cuenta con fondo suficiente,','Recarga tu saldo o realiza una transferencia bancaria'];
            }

        }   

        return [
            'code' => $code,
            'messages' => $messages,
            'responseError' => $response
        ];

    }

    /**
     * devueleve un entero que representa el estado de la reserva segun la condicion de los pagos
     *
     * @author Gabriel Camacho <kbo025@gmail.com>
     * @version 07-10-2015
     */
    public function getStatusReservation(Reservation $reservation)
    {
        $status = null; //default pre-reserva pendiente por pago
        $paid = false;
        $total = 0;
        foreach ($reservation->getPayments() as $payment) {
            if ($payment->getStatus() == 1)
                $total = $total + $payment->getAmount();
            $paid =  ($total >= $reservation->getCurrencyPrice());
        }
        if($paid)
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

    /**
     * Devuelve el status del la transacción
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getTypePayment()
    {
        return PaymentGateway::STRIPE_TDC;
    }

    public function getCutOff()
    {
        return self::CUTOFF;
    }

    /**
     * devuelve un array clave => valor con los estados posibles de el tipo de reservas que implementa
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * establece en que moneda se realizaran los cobros
     *
     * @param string $currency
     * @return Object
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();
        $currency = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $currency]);
        $this->zeroDecimalBase = $currency->getZeroDecimalBase();
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * establece en que moneda se realizaran los cobros
     *
     * @param string $zero_decimal_base
     * @return Object
     */
    public function setZeroDecimalBase($zeroDecimalBase)
    {
        $this->zeroDecimalBase = $zeroDecimalBase;        
    }

    public function getZeroDecimalBase()
    {
        return $this->zeroDecimalBase;
    }


    /**
     * algoritmo que chequea que sea un numero de TDC valido
     */
    private function checkLuhn($input)
    {
        $sum = 0;
        $numdigits = strlen($input);
        $parity = $numdigits % 2;
        for($i=0; $i < $numdigits; $i++) {
            $digit = (int)substr($input, $i, 1);

            if($i % 2 == $parity)
                $digit *= 2;
            if($digit > 9)
                $digit -= 9;

            $sum += $digit;
        }

        return ($sum % 10) == 0;
    }

    private function checkExpiredDate($month,$year)
    {
        $now = new \DateTime();

        if ((int)$month < 12) {
            $month = ((int)$month) + 1;
        } else {
            $month = 1;
            $year = ((int)$year) + 1;
        }

        $date = new \DateTime($year .'-'. $month .'-01');

        return $date > $now;
    }
}

