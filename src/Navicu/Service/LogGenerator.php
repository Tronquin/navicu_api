<?php

namespace App\Navicu\Service;

use Psr\Log\LoggerInterface;

/**
* @author Javier Vasquez <jvasquez@jacidi.com>
*/
class LogGenerator
{
    private $logger;

   public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
 
/*
    public function warning($message) {

    	$this->logger->warning($message);
    }

    public function error($message) {

    	$this->logger->error($message);

    }*/
    // Guarda las execepciones en el log de execepciones
    public function saveExeception($message) {
        global $kernel;
        $logger = $kernel->getContainer()->get('monolog.logger.exeception');
        $logger->error('**********************************');
        $logger->error('Execeptionn');
        $logger->error($message);
        $logger->error('**********************************');
    }
    // Guarda Todas las peticiones que se hacen a la ota y seguimiento de boletería
    public function saveFlight($name, $message) {
        global $kernel;
        $logger = $kernel->getContainer()->get('monolog.logger.flight');
        $logger->error('**********************************');
        $logger->error($name);
        $logger->error($message);
        $logger->error('**********************************');
    }

    // Guarda Todas las peticiones que se hacen en instapago
    public function saveInstapago($name, $message) {
        global $kernel;
        $logger = $kernel->getContainer()->get('monolog.logger.instapago');
        $logger->error('**********************************');
        $logger->error($name);
        $logger->error($message);
        $logger->error('**********************************');
    }
    // Guarda Todas las peticiones que se hacen en payeezy
    public function savePayeezy($name, $message) {
        global $kernel;
        $logger = $kernel->getContainer()->get('monolog.logger.payeezy');
        $logger->error('**********************************');
        $logger->error($name);
        $logger->error($message);
        $logger->error('**********************************');
    }
    // Guarda Todas las peticiones que se hacen en stripe
    public function saveStripe($name, $message) {
        global $kernel;
        $logger = $kernel->getContainer()->get('monolog.logger.stripe');
        $logger->error('**********************************');
        $logger->error($name);
        $logger->error($message);
        $logger->error('**********************************');
    }

    
}

