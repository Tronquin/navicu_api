<?php

namespace App\Navicu\Service;

use Psr\Log\LoggerInterface;

class LogGenerator
{
    private $logger;

   /* public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
	*/

    public function warning($message) {

    	$this->logger->warning($message);
    }

    public function error($message) {

    	$this->logger->error($message);

    }


    /**
     * Escribe en el log de boleteria
     *
     * @param string $message
     */
    public function flightLog($message)
    {
        global $kernel;

        $folder = $kernel->getLogDir() . '/flight/';
        $path = $folder . date('Y-m-d') . '.log';

        if(! is_dir($folder)) {
            mkdir($folder);
        }

        $file = fopen($path, "a");
        fwrite($file,'['.  date('Y-m-d H:i:s').'] '.$message . "\n");
        fclose($file);
    }

    
}

