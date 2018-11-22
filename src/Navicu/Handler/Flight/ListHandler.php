<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\Flight;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Consolidator;
use App\Entity\AirlineTypeRate;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Exception\OtaException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\OtaService;
use App\Navicu\Service\NavicuFlightConverter;
use App\Navicu\Service\ConsolidatorService;

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

        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();


        if ($params['searchType'] == 'oneWay') {
            $resp = 'oneWay';
            $response = OtaService::oneWay($this->getParams());
        }    
        else if ($params['searchType'] == 'roundTrip') {
            $resp = 'roundTrip';
            $response = OtaService::roundTrip($this->getParams());
        }  else {
            $resp = 'calendar';
            $response = OtaService::calendar($this->getParams());
        } 


        dump($response);
        die;

        if ($response['code'] !== OtaService::CODE_SUCCESS) {
            throw new OtaException($response['errors']);
        }     
         
        $segments = [];
        foreach ($response[$resp] as $key => $segment) {

            if (!$consolidator || ($segment['price'] > $consolidator->getCreditAvailable())) {  

                $segment['amounts'] = [];
                $segment['amounts']['original_price'] = $segment['price'];

                $negotiatedRate = false;
                foreach ($segment['flights'] as $key => $flight) {

                    if ($flight['negotiated_rate']) {
                        $negotiatedRate = $flight['negotiated_rate'];                    
                    }  

                    $airline = $manager->getRepository(Airline::class)->findOneBy(['iso' => $flight['airline']]);

                    if(is_null($airline)) {
                        $airline = $this->createAirline($flight);
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
        }    

        $response = [];
        $response['segments'] = $segments; 

        $response = $this->logoAirlineExists($response);

        return $response;
    }


    /**
     * Verifica si existe el logo de las aerolineas
     *
     * @param array $data
     * @return array
     */
    private function logoAirlineExists($data)
    {
        global $kernel;
        $dir = $kernel->getRootDir() . '/../web/images/airlines/';

        if (isset($data['segments'])) {
            foreach ($data['segments'] as $k => $segment) {
                foreach ($segment['flights'] as $j => $flight) {
                    
                    $data['segments'][$k]['flights'][$j]['logo_exists'] = file_exists($dir . $flight['airline'] . '.png');
                }                
            }
        }        

        return $data;
    }


    /**
     * Registra una aerolinea
     *
     * @param array $data
     * @return Airline
     */
    private function createAirline(array $data)
    {

        $manager = $this->container->get('doctrine')->getManager(); 

        $airline = new Airline();

        $airline
            ->setIso($data['airline'])
            ->setName($data['airlineName'])
            ->setVisible(true)
            ->setStatus(1)
            ->setCreditAvailable(0)
            ->setCreditInitial(0)
            ->setInvoiceDays(1)
            ->setPaymentDays(1)
            ->setInvoiceType(1);

        $manager->persist($airline);
        $manager->flush();

        return $airline;
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
            'searchType' => 'required|string',
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'source' => 'required|regex:/^[A-Z]{3}$/',
            'dest' => 'required|regex:/^[A-Z]{3}$/',
            'cabin' => 'required|string',
            'scale' => 'required|numeric',
        ];
    }

}