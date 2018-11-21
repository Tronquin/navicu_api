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
            $resp = 'oneWay';
            $response = OtaService::oneWay($this->getParams());
        }    
        else {
            $resp = 'roundTrip';
            $response = OtaService::roundTrip($this->getParams());
        }   

        if ($response['code'] !== OtaService::CODE_SUCCESS) {
            throw new OtaException($response['errors']);
        }  

   
         
        $segments = [];
        foreach ($response[$resp] as $key => $segment) {
            
            $segment['amounts'] = [];
            $segment['amounts']['original_price'] = $segment['price'];

            $negotiatedRate = false;
            foreach ($segment['flights'] as $key => $flight) {
                $negotiatedRate = $flight['negotiated_rate'];
                if ($negotiatedRate) {
                    break;
                }
            }

            $flightLockDate = new \DateTime($segment['flights'][0]['departure']);

            $convertedAmounts = NavicuFlightConverter::calculateFlightAmount($segment['price'], $params['currency'],
                    [   'iso' => $segment['flights'][0]['airline'],
                        'rate' => $segment['flights'][0]['rate'],
                        'from' => $segment['flights'][0]['origin'],
                        'to' => $segment['flights'][0]['destination'],
                        'departureDate' => $flightLockDate
                    ],$params['userCurrency'], 
                    [
                        'provider' => $params['provider'],
                        'negotiatedRate' =>  $negotiatedRate,                    
                    ]
                );
            
            $segment['amounts']['price'] = $convertedAmounts['subTotal'];
            $segment['amounts']['original_price_no_tax'] = $segment['priceNoTax'];
            $segment['amounts']['incrementLock'] = $convertedAmounts['subTotal'];
            $segment['amounts']['incrementConsolidator'] = $convertedAmounts['incrementConsolidator'];
            $segment['amounts']['incrementMarkup'] = $convertedAmounts['incrementMarkup'];
            $segment['amounts']['incrementExpenses'] = $convertedAmounts['incrementExpenses'];
            $segment['amounts']['incrementGuarantee'] = $convertedAmounts['incrementGuarantee'];
            $segment['amounts']['discount'] = $convertedAmounts['discount'];
            $segment['amounts']['tax'] = $convertedAmounts['tax'];
            $segments[] = $segment;

        }    

        $response = [];
        $response['segments'] = $segments; 

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