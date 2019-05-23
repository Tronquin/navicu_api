<?php
namespace App\Navicu\PaymentGateway;

/**
* @author Javier Vasquez <jvasquez@jacidi.com>
*/

abstract class BasePaymentGateway 
{
    private $container;

    public function __construct()
    {
        global $kernel;
        
        $this->setContainer($kernel->getContainer());
    }
    public function setContainer($container) {
        $this->container = $container;
    }
    public function getContainer(){
        return $this->container;
    }
}

