<?php

namespace App\Navicu\Handler\Ota;

use App\Navicu\Exception\NavicuException;
use App\Navicu\Exception\OtaException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\OtaService;

/**
 * Obtiene el mapa de asientos del avion
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class SeatMapHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $response = OtaService::seatMap($this->getParams());

        if ($response['code'] !== OtaService::CODE_SUCCESS) {
            throw new OtaException($response['errors']);
        }

        return $response;
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
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'origin' => 'required|regex:/^[A-Z]{3}$/',
            'dest' => 'required|regex:/^[A-Z]{3}$/',
            'date' => 'required|date_format:Y-m-d',
            'airline' => 'required|regex:/^[A-Z0-9]{2}$/',
            'flight' => 'required|numeric',
            'rate' => 'required|regex:/^[A-Z]{1}$/',
        ];
    }
}