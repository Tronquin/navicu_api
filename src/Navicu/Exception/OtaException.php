<?php

namespace App\Navicu\Exception;

use App\Navicu\Handler\BaseHandler;

/**
 * Exception para detener el flujo en los Handler, en especifico
 * para los errores de OTA
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class OtaException extends NavicuException
{
    /**
     * Init Exception
     *
     * @param array|string $errors
     * @param int $code
     */
    public function __construct($errors, $code = BaseHandler::CODE_EXCEPTION)
    {
        if (! is_array($errors)) {
            $errors = [$errors];
        }

        parent::__construct(sprintf('Error in OTA: %s', implode(';', $errors)), $code);
    }
}