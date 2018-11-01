<?php

namespace App\Navicu\Exception;

use App\Navicu\Handler\BaseHandler;

/**
 * Exception para detener el flujo en los Handler. Ideal para
 * validaciones y puntos de control de la aplicacion
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class NavicuException extends \Exception
{
    /**
     * Init Exception
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code = BaseHandler::CODE_EXCEPTION)
    {
        parent::__construct($message, $code, null);
    }
}