<?php

namespace App\Navicu\Handler\Ota;

use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\NavicuFlightConverter;
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
        $params = $this->getParams();
        $response = OtaService::fareFamily($params);

        foreach ($response['fareFamily'] as $i => $fareFamily) {
            // Se calcula los nuevos montos de la reserva en base
            // a la informacion obtenida en el fare family

            $price = 0;

            if (isset($fareFamily['prices']['ADT'])) {
                // precio por adultos
                $price += ($fareFamily['prices']['ADT'] * $params['adt']);
            }

            if (isset($fareFamily['prices']['CNN'])) {
                // precio por niños
                $price += ($fareFamily['prices']['CNN'] * $params['cnn']);
            }

            if (isset($fareFamily['prices']['INF'])) {
                // precio por infantes
                $price += ($fareFamily['prices']['INF'] * $params['inf']);
            }

            if (isset($fareFamily['prices']['INS'])) {
                // precio por infantes con asientos
                $price += ($fareFamily['prices']['INS'] * $params['ins']);
            }

            $lockData = [
                'iso' => $fareFamily['itinerary'][0]['airline'],
                'rate' => $fareFamily['itinerary'][0]['rate'],
                'from' => $fareFamily['itinerary'][0]['origin'],
                'to' => $fareFamily['itinerary'][0]['destination'],
                'departureDate' => new \DateTime($fareFamily['itinerary'][0]['departure'])
            ];

            $convertedAmounts = NavicuFlightConverter::calculateFlightAmount($price, 'USD',  $lockData,
                $params['userCurrency'],
                [
                    'provider' => $params['provider'],
                    'negotiatedRate' =>  $fareFamily['itinerary'][0]['negotiated_rate'],
                ]
            );

            $response['fareFamily'][$i]['price'] = $convertedAmounts['subTotal'];
        }

        return $response['fareFamily'];
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
            'userCurrency' => 'required|regex:/^[A-Z]{3}$/',
        ];
    }
}