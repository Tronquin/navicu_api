<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\ExchangeRateHistory;
use App\Entity\FlightReservation;
use App\Entity\FlightGeneralConditions;
use App\Entity\FlightFareFamily;
use App\Entity\Flight;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Gds;
use App\Entity\Consolidator;
use App\Entity\FlightReservationGds;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\ConsolidatorService;
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
 	/** 
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
    	$manager = $this->container->get('doctrine')->getManager(); 		

        $params = $this->getParams();  
        $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();    
        $reservation = new FlightReservation();

        $totalIncrementExpenses = $totalIncrementExpensesLocal = 0;
		$totalIncrementGuarantee = $totalIncrementGuaranteeLocal = 0;
		$totalDiscount = $totalDiscountLocal = 0;
        $totalIncrementAmountLocal = $totalIncrementAmount = 0;
        $totalIncrementLockLocal = $totalIncrementLock = 0;
        $totalIncrementMarkupLocal = $totalIncrementMarkup = 0;
		$subTotal = $tax = 0;
		$subTotalLocal = $taxLocal  = 0;
		$round = 2;		
		
	
		foreach ($params['itinerary'] as $key => $itinerary) {

			$this->validateItinerary($itinerary);

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

	    	foreach ($itinerary['fareFamily'] as $key => $fareFamily) {

	            $farefamilyEntity = $this->createFareFamilyFromData($fareFamily);
				$reservationGds->addFlightFareFamily($farefamilyEntity); 
	    	}


	    	$flightLockDate = new \DateTime($itinerary['flights'][0]['departure']);
	        $convertedAmounts = NavicuFlightConverter::calculateFlightAmount($itinerary['price'], $itinerary['currency'],
	                    [   'iso' => $itinerary['flights'][0]['airline'],
	                        'rate' => $itinerary['flights'][0]['rate'],
	                        'from' => $itinerary['flights'][0]['from'],
	                        'to' => $itinerary['flights'][0]['to'],
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

	        	$localAmounts = NavicuFlightConverter::calculateFlightAmount($itinerary['price'], $itinerary['currency'],
	                    [   'iso' => $itinerary['flights'][0]['airline'],
	                        'rate' => $itinerary['flights'][0]['rate'],
	                        'from' => $itinerary['flights'][0]['from'],
	                        'to' => $itinerary['flights'][0]['to'],
	                        'departureDate' => $flightLockDate
	                    ],CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
	                    [
	                        'provider' => $itinerary['flights'][0]['provider'],
	                        'negotiatedRate' =>  $negotiatedRate,                    
	                    ]
	                );
	        }	        

	        $reservationGds = $this->updateReservationGds($reservationGds, $itinerary, $params['userCurrency'], $localAmounts);

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

		$reservation
	        ->setReservationDate(new \DateTime('now'))
	       	->setChildNumber($itinerary['cnn'])
        	->setAdultNumber($itinerary['adt'])
        	->setInfNumber($itinerary['inf'])
        	->setInsNumber($itinerary['ins'])
        	->setPublicId()
	        ->setIpAddress($params['ipAddress'])
	        ->setOrigin('navicu web');		 

	 	$manager->persist($reservation);
    	$manager->flush();

    	$response['public_id'] = $reservation->getPublicId();
        $response['incrementAmount'] = $totalIncrementAmount;
        $response['incrementLock'] = $totalIncrementLock;
        $response['incrementMarkup'] = $totalIncrementMarkup;
		$response['currencySymbol'] = $params['userCurrency'];
		$response['subtotal'] = $subTotal;
		$response['tax'] = $tax;
		$response['incrementExpenses'] = $totalIncrementExpenses;
		$response['incrementGuarantee'] = $totalIncrementGuarantee;
		$response['discount'] = $totalDiscount;
 	

		return $response;

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

		if (($repAirFrom[0]['country_code'] !== 'VE') || ($repAirTo[0]['country_code'] !== 'VE')){
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
        ->setInsNumber($itinerary['ins'])
        ->setSubtotalOriginal($itinerary['original_price'])
        ->setTaxOriginal($itinerary['original_price'] - $itinerary['original_price_no_tax'])
        ->setTaxes($itinerary['taxes'])
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
	        ->setIsRefundable($itinerary['flights'][0]['isRefundable'])
	        ->setStatus(FlightReservation::STATE_IN_PROCESS)
	        ->setGds($manager->getRepository(Gds::class)->findOneBy(['name' => $itinerary['flights'][0]['provider']]));

	        $dollarRates = NavicuCurrencyConverter::getLastRate($itinerary['currency'], new \DateTime('now'));
	        $currencyRates = NavicuCurrencyConverter::getLastRate($userCurrency, new \DateTime('now'));

   
      	$reservationGds->setDollarRateConvertion((CurrencyType::isLocalCurrency($itinerary['currency'])) ? $dollarRates['buy'] : $dollarRates['sell']);
      	$reservationGds->setCurrencyRateConvertion((CurrencyType::isLocalCurrency($userCurrency)) ? $currencyRates['buy'] : $currencyRates['sell']);

      	$manager->persist($reservationGds);
    	$manager->flush();

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
		$from = $manager->getRepository(Airport::class)->findOneBy(['iata' => $flightData['from']]);
		$to = $manager->getRepository(Airport::class)->findOneBy(['iata' => $flightData['to']]);	

		$flight
				->setNumber($flightData['number_flight'])
				->setAirline($airline)
				->setDepartureTime(\DateTime::createFromFormat('Y-m-d H:i:s', $flightData['departure']))
				->setArrivalTime(\DateTime::createFromFormat('Y-m-d H:i:s', $flightData['arrival']))
				->setAirportFrom($from)
				->setAirportTo($to)
				->setDuration($flightData['duration'])
                ->setReturnFlight($isReturn)			      
				->setSegment($flightData['segment'])
				->setCabin($flightData['cabin'])			
		;

		$manager->persist($flight);
    	$manager->flush();

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
            'from' => 'required|regex:/^[A-Z]{3}$/',
            'to'  => 'required|regex:/^[A-Z]{3}$/',
            'airline' => 'required|regex:/^[A-Z]{2}$/', 
            'number_flight' => 'required',
            'departure' => 'required',
            'arrival' => 'required',
            'provider' => 'required',
            'rate' => 'required|regex:/^[A-Z]{1}$/',
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
            'ins' => 'required|numeric',
            'original_price'=> 'required|numeric',
	        'original_price_no_tax'=> 'required|numeric',
	        'taxes'=> 'required',
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
        'userCurrency' => 'required|regex:/^[A-Z]{3}$/',
        'ipAddress' => 'required|/^(?:(?:[1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}(?:[1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^localhost$/',
        'itinerary' => 'required'
        ];
    }



}