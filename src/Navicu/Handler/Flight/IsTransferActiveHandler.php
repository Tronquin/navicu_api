<?php

namespace App\Navicu\Handler\Flight;

use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Verifica si esta activa la opcion transferencia en boleteria
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class IsTransferActiveHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $now = new \DateTime('now');
        $timeLimit = new \DateTime('now');
        $isTransferVisible = false;

        // El tiempo limite para transferir es de 2 horas
        $timeLimit = $timeLimit->modify('+2 hours');
        $timeLimit = $timeLimit->format('Y-m-d H:i:s');
        //El tiempo de transferencia es de 6 am hasta las 7 pm
        $transferStart = new \DateTime('now 06:00:00');
        $transferEnd = new \DateTime('now 19:00:00');

        if ($now > $transferStart && $now < $transferEnd) {
            $isTransferVisible = true;
            
        }

        return compact('isTransferVisible', 'timeLimit');
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
    protected function validationRules() : array
    {
        return [
            'provider' => 'required|in:KIU,AMA'
        ];
    }
}