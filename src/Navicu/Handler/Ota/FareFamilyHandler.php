<?php

namespace App\Navicu\Handler\Ota;

use App\Entity\Airport;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Exception\OtaException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\OtaService;

/**
 * Obtiene informacion del Fare Family
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class FareFamilyHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $response = OtaService::fareFamily($this->getParams());

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
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'itinerary' => 'required',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
        ];
    }
}