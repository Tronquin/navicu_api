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
        $isTransferVisible = false;
        $timeLimit = $now->format('Y-m-d H:i:s');

        if ($params['provider'] === 'KIU') {
            // 24 horas para transferir

            $timeLimit = $now->modify('+1 day')->format('Y-m-d H:i:s');
            $isTransferVisible = true;

        } elseif ($params['provider'] === 'AMA') {
            // Hasta las 12 de la noche hora de Panama para transferir

            $transferStart = new \DateTime('now 02:00:00');
            $transferEnd = new \DateTime('now 19:00:00');
            $allowTo = new \DateTime('now 21:00:00');

            if ($now > $transferStart && $now < $transferEnd) {
                $isTransferVisible = true;
                $timeLimit = $allowTo->format('Y-m-d H:i:s');
            }
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