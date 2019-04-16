<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\Flight;
use App\Entity\FlightLock;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Consolidator;
use App\Entity\AirlineTypeRate;
use App\Entity\FlightSearchRegister;
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
        $manager = $this->getDoctrine()->getManager();
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();

        if (isset($params['source'])) {
            $params['source'] = $this->getAirportsByCity($params['source'], $params['sourceSearchType']);
        }

        if (isset($params['dest'])) {
            $params['dest'] = $this->getAirportsByCity($params['dest'], $params['destSearchType']);
        }

        $resp = $params['searchType'];
        if ($params['searchType'] == 'oneWay') {
            $response = OtaService::oneWay($params);
        }    
        elseif ($params['searchType'] == 'roundTrip') {
            $response = OtaService::roundTrip($params);
        }
        elseif ($params['searchType'] == 'twiceOneWay') {
            $response = OtaService::twiceOneWay($params);
        }
        elseif ($params['searchType'] == 'multiple') {
            $resp = 'oneWay';
            $response = OtaService::multiple($params);
        }
        else {
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
                        $this->createAirline($flight);
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
        $this->saveFlightSearch($responseFinal);
        return $responseFinal;
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
        $validations = [
            'searchType' => 'required|string',
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'cabin' => 'required',
            'scale' => 'required|numeric',
            'baggage' => 'required|numeric',
            'sourceSearchType' => 'required',
            'destSearchType' => 'required',
            'roundTrip' => 'in:1,0'
        ];

        $params = $this->getParams();
        if (isset($params['searchType']) && $params['searchType'] !== 'multiple') {
            $validations = array_merge($validations, [
                'startDate' => 'required',
                'endDate' => 'required',
                'source' => 'required',
                'dest' => 'required',
            ]);
        }

        return $validations;
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
        $manager = $this->getDoctrine()->getManager();

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
     * Obtiene un arreglo de aeropuertos en base a la ubicacion. Si la busqueda
     * es para New York por ejemplo, retorna todos los aeropuertos de esa ciudad
     *
     * @param string $iata
     * @param string $searchType
     * @return array
     */
    private function getAirportsByCity(string $iata, string $searchType) : array
    {
        $manager = $this->getDoctrine()->getManager();
        $mainAirport = $manager->getRepository(Airport::class)->findOneBy(['iata' => $iata]);
        $airports = [];

        if ($searchType == 'group') {

            // Se busco una ciudad, agrego todos los aeropuertos de la misma
            $cityAirports = $manager->getRepository(Airport::class)->findBy(['cityName' => $mainAirport->getCityName()]);
            foreach ($cityAirports  as $key => $airport) {
                $airports[] = $airport->getIata();
            }

        } else {
            // Es aeropuerto, se hace busqueda solo para este
            $airports[] = $mainAirport->getIata();
        }

        return $airports;
    }
     /**
     * Guarda la busqueda y la respuesta emitida
     *
     * @param array $parameters
     * @param array $response
     */
    private function saveFlightSearch(array $response)
    {
        $manager = $this->getDoctrine()->getManager();
        $parameters = $this->getParams();
        $flightSearchRegister = new FlightSearchRegister();
        $flightSearchRegister
        ->setAdults($parameters['adt'])
        ->setChildren($parameters['cnn'])
        ->setBaby($parameters['inf'])
        ->setCountry($parameters['country'])
        ->setCurrency($parameters['currency'])
        ->setCabin($parameters['cabin'])
        ->setScale($parameters['scale'])
        ->setBaggage($parameters['baggage'])
        ->setEndDate(new \DateTime($parameters['endDate']))
        ->setSearchType($parameters['searchType'])
        ->setDate(new \DateTime($parameters['date']))
        ->setUserCurrency($parameters['userCurrency'])
        ->setSourceSearchType($parameters['sourceSearchType'])
        ->setDestSearchType($parameters['destSearchType'])
        ->setRoundTrip($parameters['roundTrip'])
        ->setItinerary( isset($parameters['itinerary']) ? $parameters['itinerary'] : null)
        ->setSource(isset($parameters['source']) ? $parameters['source'] : null)
        ->setDest(isset($parameters['dest']) ? $parameters['dest']: null)
        ->setStarDate(isset($parameters['startDate']) ?new \DateTime($parameters['startDate'])  : null)
        ->setProvider($parameters['provider'])
        ->setResponse($response)
    ;

    $manager->persist($flightSearchRegister);
    $manager->flush();

    }
}