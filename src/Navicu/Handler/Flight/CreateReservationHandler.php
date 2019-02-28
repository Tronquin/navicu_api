<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\FlightReservation;
use App\Entity\FlightGeneralConditions;
use App\Entity\FlightFareFamily;
use App\Entity\Flight;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Gds;
use App\Entity\FlightReservationGds;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\NavicuValidator;
use App\Navicu\Service\NavicuCurrencyConverter;
use App\Navicu\Service\NavicuFlightConverter;

/**
 * Handler que resume las funcionalidades necesarias para crear 
 * FlightReservation, FlighReservationGds,FlightFareFamily y Flight
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class CreateReservationHandler extends BaseHandler
{ 
	const CURRENCY_EURO = 'EUR';
 	/** 
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
    	$manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();
        $token_interface = $params['ti'];
		$ip = $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
        $reservation = new FlightReservation();
        $totalIncrementExpenses = $totalIncrementExpensesLocal = 0;
		$totalIncrementGuarantee = $totalIncrementGuaranteeLocal = 0;
		$totalDiscount = $totalDiscountLocal = 0;
        $totalIncrementAmount = 0;
        $totalIncrementLock = 0;
        $totalIncrementMarkup = 0;
		$subTotal = $tax = 0;

		$provider = 'KIU';
		foreach ($params['itineraries'] as $key => $itinerary) {
            $itinerary['currency'] = $itinerary['flights'][0]['money_type'];
			$this->validateItinerary($itinerary);

			/** Valida si uno de los proveedores de la reserva es Amadeus**/
			if ($itinerary['flights'][0]['provider'] == 'AMA') {
                $provider = 'AMA';
            }   

			$reservationGds = new FlightReservationGds();
	    	$negotiatedRate = false;

	    	foreach ($itinerary['flights'] as $key => $flight) {

	    		$this->validateFlight($flight);

	    		 if ($flight['negotiated_rate']) {
	                    $negotiatedRate = $flight['negotiated_rate'];                    
	             } 

	            $isReturn = ($itinerary['schedule'] == FlightReservation::ROUND_TRIP) && ((int)$flight['segment'] > 1);
	            $flightEntity = $this->createFlightFromData($flight, $isReturn);
				$reservationGds->addFlight($flightEntity); 
			}
			$farefamilyEntity = $this->createFareFamilyFromData($itinerary['fare_family']);
			$reservationGds->addFlightFareFamily($farefamilyEntity);

	    	$flightLockDate = new \DateTime($itinerary['flights'][0]['departure']);
	        $convertedAmounts = NavicuFlightConverter::calculateFlightAmount($itinerary['original_price'], $itinerary['currency'],
	                    [   'iso' => $itinerary['flights'][0]['airline'],
	                        'rate' => $itinerary['flights'][0]['rate'],
	                        'from' => $itinerary['flights'][0]['origin'],
	                        'to' => $itinerary['flights'][0]['destination'],
	                        'departureDate' => $flightLockDate
	                    ],$params['userCurrency'], 
	                    [
	                        'provider' => $itinerary['flights'][0]['provider'],
	                        'negotiatedRate' =>  $negotiatedRate,                    
	                    ]
	                );

	        if (CurrencyType::getLocalActiveCurrency()->getAlfa3() ==  $params['userCurrency']) {
	        	$localAmounts = $convertedAmounts;
	        } else {
	        	$localAmounts = NavicuFlightConverter::calculateFlightAmount($itinerary['original_price'], $itinerary['currency'],
	                    [   'iso' => $itinerary['flights'][0]['airline'],
	                        'rate' => $itinerary['flights'][0]['rate'],
	                        'from' => $itinerary['flights'][0]['origin'],
	                        'to' => $itinerary['flights'][0]['destination'],
	                        'departureDate' => $flightLockDate
	                    ],CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
	                    [
	                        'provider' => $itinerary['flights'][0]['provider'],
	                        'negotiatedRate' =>  $negotiatedRate,                    
	                    ]
	                );
	        }	        

	        $reservationGds = $this->updateReservationGds($reservationGds, $itinerary, $params['userCurrency'], $localAmounts);
	        $manager->persist($reservationGds);
	        $reservation->addGdsReservation($reservationGds);      	

	        // Incrementos en moneda del usuario
			$totalIncrementExpenses += $convertedAmounts['incrementExpenses'];
			$totalIncrementGuarantee += $convertedAmounts['incrementGuarantee'];
			$totalDiscount += $convertedAmounts['discount'];
			$totalIncrementLock += $convertedAmounts['incrementLock'];
			$totalIncrementMarkup += $convertedAmounts['incrementMarkup'];
			$subTotal += $convertedAmounts['subTotal'];
			$tax  += $convertedAmounts['tax'];  
		}      

		$options = $this->getTransferOptions($provider);

		$reservation
	        ->setReservationDate(new \DateTime('now'))
	       	->setChildNumber($itinerary['cnn'])
        	->setAdultNumber($itinerary['adt'])
        	->setInfNumber($itinerary['inf'])
        	->setInsNumber($itinerary['ins'] ?? 0)
        	->setExpireDate(new \DateTime($options['timeLimit']))
	        ->setIpAddress($ip ?? null)
	        ->setOrigin('navicu web');

        if (is_object($token_interface->getToken()->getUser())) {
            $reservation->setClientProfile($token_interface->getToken()->getUser()->getClientProfile()[0]);
        }

	 	$manager->persist($reservation);
    	$manager->flush();    	

    	/** @var CurrencyType $userCurrency */
    	$userCurrency = $manager->getRepository(CurrencyType::class)->findOneBy([ 'alfa3' => $params['userCurrency'] ]);

        $amounts['incrementAmount'] = $totalIncrementAmount;
        $amounts['incrementLock'] = $totalIncrementLock;
        $amounts['incrementMarkup'] = $totalIncrementMarkup;
		$amounts['currencySymbol'] = $userCurrency->getSimbol();
		$amounts['subtotal'] = $subTotal;
		$amounts['tax'] = $tax;
		$amounts['incrementExpenses'] = $totalIncrementExpenses;
		$amounts['incrementGuarantee'] = $totalIncrementGuarantee;
		$amounts['discount'] = $totalDiscount;
		$now = new \DateTime('now');

    	$response = [
            'public_id' => $reservation->getPublicId(),
    		'amounts' => $amounts,
    		'isTransferVisible' => $options['isTransferVisible'],
    		'timeLimit' =>$options['timeLimit'],
    		'date_servidor' => $now->format('Y-m-d H:i:s')
    	];    	

		return $response;
    }

	/**
	 * Funcion que devuelve las condiciones de visibilidad de la opcion de transferencia en boleteria
     *
	 * @param $provider
	 * @throws NavicuException
	 * @return array
	 */
    private function getTransferOptions ($provider) : array
    {
    	$handler = new IsTransferActiveHandler();
    	$handler->setParam('provider', $provider);
    	$handler->processHandler();

    	if (! $handler->isSuccess()) {
    	    $this->addErrorToHandler($handler->getErrors()['errors']);

    	    throw new NavicuException('IsTransferActiveHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

        return $handler->getData()['data'];
    }

    /**     
     *
     * @return FlightReservationGds
     * @throws NavicuException
     * @param FlightReservationGds $reservationGds
     * @param array $itinerary, itinerario de la reserva
     * @param string $userCurrency, moneda del usuario
     * @param array $convertedAmounts, array de montos convertidos a la moneda LOCAL
     *
     */
    private function updateReservationGds(FlightReservationGds $reservationGds, $itinerary, $userCurrency, $convertedAmounts) : ?FlightReservationGds
	{
		$manager = $this->container->get('doctrine')->getManager();

		$repAirFrom = $manager->getRepository(Airport::class)->findAllByAirport($itinerary['from']);
		$repAirTo = $manager->getRepository(Airport::class)->findAllByAirport($itinerary['to']);
		$airline = $manager->getRepository(Airline::class)->findOneBy(['iso' => $itinerary['flights'][0]['airline']]);

		if (($repAirFrom[0]['country_code'] !== 'VE') || ($repAirTo[0]['country_code'] !== 'VE')) {
			$airlineCommission = $airline->getInternationalCommission();
		} else {
			$airlineCommission = $airline->getNationalCommission();
		}	

        $currency_reservation = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $userCurrency]);
        $currency_gds = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $itinerary['currency']]);

        $reservationGds
        ->setCurrencyGds($currency_gds)
        ->setCurrencyReservation($currency_reservation)	        
        ->setReservationDate(new \DateTime('now'))			
        ->setChildNumber($itinerary['cnn'])
        ->setAdultNumber($itinerary['adt'])
        ->setInfNumber($itinerary['inf'])
        ->setInsNumber($itinerary['ins'] ?? 0)
        ->setSubtotalOriginal($itinerary['original_price'])
        ->setTaxOriginal($itinerary['original_price'] - $itinerary['price_no_tax'])
        ->setTaxes($itinerary['taxes'] ?? '')
        ->setSubtotal($convertedAmounts['subTotal'])
        ->setTax($convertedAmounts['tax'])
        ->setIncrementConsolidator($convertedAmounts['incrementConsolidator'])
        ->setMarkupIncrementAmount($convertedAmounts['incrementMarkup'])
        ->setMarkupIncrementType(FlightGeneralConditions::INCREMENT_TYPE_PERCENTAGE) 
        ->setMarkupCurrency($userCurrency)
        ->setIncrementExpenses($convertedAmounts['incrementExpenses'])
        ->setIncrementGuarantee($convertedAmounts['incrementGuarantee'])
        ->setDiscount($convertedAmounts['discount'])
        ->setAirlineProvider($manager->getRepository(Airline::class)->findOneBy(['iso' => $itinerary['flights'][0]['airline']]))
        ->setAirlineCommission($airlineCommission)
        ->setIsRefundable($itinerary['flights'][0]['is_refundable'])
        ->setStatus(FlightReservation::STATE_IN_PROCESS)
        ->setGds($manager->getRepository(Gds::class)->findOneBy(['name' => $itinerary['flights'][0]['provider']]));

		$dollarRates = NavicuCurrencyConverter::getLastRate('USD', new \DateTime('now'));
		$currencyRates = NavicuCurrencyConverter::getLastRate($userCurrency, new \DateTime('now'));

		$reservationGds->setDollarRateConvertion((CurrencyType::isLocalCurrency($itinerary['currency'])) ? $dollarRates['buy'] : $dollarRates['sell']);
		
		if(CurrencyType::isLocalCurrency($itinerary['currency']) && $userCurrency == self::CURRENCY_EURO){
			$reservationGds->setCurrencyRateConvertion($currencyRates['buy']);
		}else{
			$reservationGds->setCurrencyRateConvertion((CurrencyType::isLocalCurrency($userCurrency)) ? $currencyRates['buy'] : $currencyRates['sell']);
		} 

      	return $reservationGds;
	}


	/**
     * Crear Entidad Flight
     * @param  array $flightData
     * @param  bool $isReturn 
     * @return Flight
     */
    private function createFlightFromData(array $flightData, $isReturn) : ?Flight
	{
		$flight = new Flight();	
		$manager = $this->container->get('doctrine')->getManager();        

		$airline = $manager->getRepository(Airline::class)->findOneBy(['iso' => $flightData['airline']]);
		$from = $manager->getRepository(Airport::class)->findOneBy(['iata' => $flightData['origin']]);
		$to = $manager->getRepository(Airport::class)->findOneBy(['iata' => $flightData['destination']]);	

		$flight
				->setNumber($flightData['flight'])
				->setAirline($airline)
				->setDepartureTime(\DateTime::createFromFormat('Y-m-d H:i:s', $flightData['departure']))
				->setArrivalTime(\DateTime::createFromFormat('Y-m-d H:i:s', $flightData['arrival']))
				->setAirportFrom($from)
				->setAirportTo($to)
				->setDuration($flightData['duration'])
                ->setReturnFlight($isReturn)			      
				->setSegment($flightData['segment'])
				->setCabin($flightData['cabin'])
                ->setTypeRate($flightData['rate'])
                ->setTecnicalStop($flightData['technical_stop'])
		;

		return $flight;
	}


	/**
     * Crear Entidad FlightFareFamily
     * @param  array fareFamilyData
     * @return FlightFareFamily
     */
	private function createFareFamilyFromData($fareFamilyData) : ?FlightFareFamily
	{
		$fareFamily = new FlightFareFamily();
		$manager = $this->container->get('doctrine')->getManager(); 
		$fareFamily
				->setName($fareFamilyData['name'])
				->setDescription($fareFamilyData['description'])
				->setServices(json_encode($fareFamilyData['services']))
				->setPrices(json_encode($fareFamilyData['prices']))
				->setSelected($fareFamilyData['selected'])
		;

		$manager->persist($fareFamily);

		return $fareFamily;
	}

    /**
     * Todas las reglas de validacion para los parametros de los vuelos
     * 
	**/
	protected function validateFlight($flight):bool
    {
		$validator = new NavicuValidator();	
        $validator->validate($flight, [
        	'segment' => 'required|numeric',
            'origin' => 'required|regex:/^[A-Z]{3}$/',
            'destination'  => 'required|regex:/^[A-Z]{3}$/',
            'airline' => 'required', 
            'flight' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'provider' => 'required',
            'rate' => 'required|regex:/^[A-Z]{1}$/',
            'technical_stop' => 'required'
        ]); 

         if ($validator->hasError()) {
         	throw new NavicuException('Error in Flight Elements: ' . implode(';', $validator->getErrors()));
        }
        return true;
    }

    /**
     * Todas las reglas de validacion para los parametros de lla busqueda
     * 
	**/
    protected function validateItinerary($itinerary):bool
    {
		$validator = new NavicuValidator();	
        $validator->validate($itinerary, [
            'currency' => 'required|in:VES,USD',
            'from' => 'required|regex:/^[A-Z]{3}$/',
            'to' => 'required|regex:/^[A-Z]{3}$/',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'numeric',
            'original_price'=> 'required|numeric',
	        'price_no_tax'=> 'required|numeric',
	        'schedule'=> 'required',
	        'flights' => 'required'
        ]); 

        if ($validator->hasError()) {
         	throw new NavicuException('Error in Itinerary Elements: ' . implode(';', $validator->getErrors()));
        }
        return true;
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
    protected function validationRules(): array
    {
        return [
        /*'userCurrency' => 'required|regex:/^[A-Z]{3}$/',
        'ipAddress' => 'required|/^(?:(?:[1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}(?:[1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^localhost$/',
        'itinerary' => 'required'
        */
        ];
    }



}