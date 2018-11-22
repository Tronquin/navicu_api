<?php

namespace App\Navicu\Handler;


use App\Navicu\Exception\NavicuException;
use App\Navicu\Service\NavicuValidator;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Navicu\Service\PaymentGatewayService;


class ExecuteTdcTransactionInstapagoHandler extends BaseHandler
{
	/**
	 * La variable contiene la funcionalidades del servicio de email
	 *
	 * @var EmailInterface $emailService
	 */
	protected $emailService;

    /**
     * SecurityService
     * @var
     */
    protected $secureInf;


    /**
     * Método Get del la interfaz del serivicio Email
     * @internal param EmailInterface $emailService
     * @return \Navicu\Core\Application\Contract\EmailInterface
     */
    public function getEmailService()
    {
        return $this->emailService;
    }

	/**
	 * Método Set del la interfaz del servicio Email
	 * @param EmailInterface $emailService
	 */
	public function setEmailService(EmailInterface $emailService)
	{
		$this->emailService = $emailService;
	}

    /**
     *  Ejecuta las tareas solicitadas
     *
     * @param Command $command
     * @param RepositoryFactoryInterface $rf
     * @return ResponseCommandBus
     */
    public function handler(): array
    {
        global $kernel;
        //$params = $this->getParams();

        $paymentGateway = PaymentGatewayService::getPaymentGateway(1);
        $response['success'] = false;
       
        $response = $paymentGateway->executePayment(array('amount'=>10, 'id' => '123456')); 
        
        return compact($response);
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
           
        ];
    }
       
}