<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\Flight;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\AirlineTypeRate;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Exception\OtaException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\OtaService;
use App\Navicu\Service\NavicuFlightConverter;

/**
 * Listado de vuelos
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class ListHandler extends BaseHandler
{
    /** 
     * @return array
     * @throws NavicuException
     */

    protected function handler() : array
    {

        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        if ($params['roundTrip'] == 0) {
            $response = OtaService::oneWay($this->getParams());
        }    
        else {
            $response = OtaService::roundTrip($this->getParams());
        }   

        if ($response['code'] !== OtaService::CODE_SUCCESS) {
            throw new OtaException($response['errors']);
        }  

        $segments = [];
        foreach ($response['oneWay'] as $key => $segment) {
            $segment['original_price'] = $segment['price'];
            $convertedAmounts = NavicuFlightConverter::calculateFlightAmount($segment['price'], $params['currency'],[],$params['userCurrency'], []);
            $segment['price'] = $convertedAmounts['subTotal'];
            $segments[] = $segment;
        }    

        $response = [];
        $response['segments'] = $segments; 

        dump($response);
        die;

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
            'provider' => 'required|regex:/^[A-Z]{3}$/',
        ];
    }

}