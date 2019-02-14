<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\Flight;
use App\Entity\FlightLock;
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

        $sourceAirports = [];

        $airportSource = $manager->getRepository(Airport::class)->findOneBy(['iata' => $params['source']]);

        if ($params['sourceSearchType'] == 'group') {            
            $objectAirports = $manager->getRepository(Airport::class)->findBy(['cityName' => $airportSource->getCityName()]);

            foreach ($objectAirports  as $key => $airportSource) {
                $sourceAirports[] = $airportSource->getIata();
            } 

        } else {
            $sourceAirports[] = $airportSource->getIata();
        }

        $airportDest = $manager->getRepository(Airport::class)->findOneBy(['iata' => $params['dest']]);
        if ($params['sourceSearchType'] == 'group') {            
            $objectAirports = $manager->getRepository(Airport::class)->findBy(['cityName' => $airportDest->getCityName()]);

            foreach ($objectAirports  as $key => $airportDest) {
                $destAirports[] = $airportDest->getIata();
            } 

        } else {
            $destAirports[] = $airportDest->getIata();
        }

        $params['source'] = $sourceAirports;
        $params['dest'] = $destAirports;

        if ($params['searchType'] == 'oneWay') {
            $resp = 'oneWay';
            $response = OtaService::oneWay($params);
        }    
        elseif ($params['searchType'] == 'roundTrip') {
            $resp = 'roundTrip';
            $response = OtaService::roundTrip($params);
        }
        elseif ($params['searchType'] == 'twiceOneWay') {
            $resp = 'twiceOneWay';
            $response = OtaService::twiceOneWay($params);
        } else {
            $resp = 'calendar';
            $response = OtaService::calendar($params);
        } 

        if ($response['code'] !== OtaService::CODE_SUCCESS) {
            throw new OtaException($response['errors']);
        } 


        $pricesLock = 0;
        $responseFinal = [];
        foreach ($response[$resp] as $keyGlobal => $global) {

            $itinerary['price'] = 0;
            $itinerary['itineraries'] = [];

            foreach ($global['itineraries'] as $keyS => $segment) {          

                if ($segment['flights'][0]['provider'] === 'AMA' &&
                    (! $consolidator || $consolidator->getCreditAvailable() < $segment['price'])
                ) {
                    // Si el proveedor es Amadeus && (No esta configurado el consolidador || el credito no es suficiente)
                    continue;
                }

                $segment['original_price'] = $segment['price'];
                $negotiatedRate = false;
                foreach ($segment['flights'] as $key => $flight) {

                    if ($flight['negotiated_rate']) {
                        $negotiatedRate = $flight['negotiated_rate'];
                    }

                    $airline = $manager->getRepository(Airline::class)->findOneBy(['iso' => $flight['airline']]);
                    if (is_null($airline)) {
                        $airline = $this->createAirline($flight);
                    }

                    /** @var $flightLock, un bloqueo predefinido, de existir se debe tomar
                     * en cuenta el precio dle bloqueo en lugar de el suministrado por el GDS
                     **/
                    
                    $flightLock = $manager->getRepository(FlightLock::class)->findLock(
                        $flight['airline'],
                        $flight['rate'],
                        $flight['origin'],
                        $flight['destination'],
                        new \DateTime($flight['departure']),
                        $flight['money_type']
                    );

                    if ($flightLock) {
                        $pricesLock += $flightLock->getAmount();
                    }
                }

                $segment['price'] = ($segment['price'] > $pricesLock) ? $segment['price'] : $pricesLock;
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

                $segment['price'] = $convertedAmounts['subTotal'];
                $itinerary['price'] +=  $segment['price'];
                $itinerary['itineraries'][] = $segment;                         

            }

            $responseFinal[$keyGlobal]['groupItinerary'] = $itinerary;
            
        }   

        $responseFinal = $this->logoAirlineExists($responseFinal);
     
        return $responseFinal;
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

        if (isset($data[0]['groupItinerary'])) {
            foreach ($data as $k => $groupItinerary) {
                foreach ($groupItinerary['groupItinerary']['itineraries'] as $j => $itinerary) {
                    foreach ($itinerary['flights'] as $i => $flight) {

                        $data[$k]['groupItinerary']['itineraries'][$j]['flights'][$i]['logo_exists'] = file_exists($dir . $flight['airline'] . '.png');
                    }    
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
            'source' => 'required',
            'dest' => 'required',
            'cabin' => 'required',
            'scale' => 'required|numeric',
            'startDate' => 'required',
            'endDate' => 'required',
            'baggage' => 'required|numeric',
            'sourceSearchType' => 'required',
            'destSearchType' => 'required',
            'roundTrip' => 'in:1,0'
        ];
    }

}