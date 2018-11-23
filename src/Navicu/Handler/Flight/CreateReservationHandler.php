<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\ExchangeRateHistory;
use App\Entity\FlightReservation;
use App\Entity\Flight;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\Gds;
use App\Entity\Consolidator;
use App\Entity\FlightReservationGds;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\NavicuCurrencyConverter;
use App\Navicu\Service\NavicuFlightConverter;


/**
 * Handler que resume las funcionalidades necesarias para crear 
 * la reservacion Navicu, reservaciones gds y vuelos
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class CreateReservationHandler extends BaseHandler
{ 

 	/**
     * Aqui va la logica
     *
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

		$params['itinerary'] = json_decode($params['itinerary'], true);
		
	
		foreach ($params['itinerary'] as $key => $itinerary) {

			$reservationGds = new FlightReservationGds();
	    	$negotiatedRate = false;	   

	    	foreach ($itinerary['flights'] as $key => $flight) {

	    		 if ($flight['negotiated_rate']) {
	                    $negotiatedRate = $flight['negotiated_rate'];                    
	             } 


	            $flightEntity = $this->createFlightFromData($flight);
				$reservationGds->addFlight($flightEntity); 
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

	        $reservationGds = $this->updateReservationGds($reservationGds, $itinerary, $params, $convertedAmounts);

	        $reservation->addGdsReservation($reservationGds); 	     	
	        
	        // Incrementos en Local
			$totalIncrementExpensesLocal += $localAmounts['incrementExpenses'];
			$totalIncrementGuaranteeLocal += $localAmounts['incrementGuarantee'];
			$totalDiscountLocal += $localAmounts['discount'];
			$subTotalLocal += $localAmounts['subTotal'];
			$taxLocal  += $localAmounts['tax'];

	        // Incrementos en moneda del usuario
			$totalIncrementExpenses += $convertedAmounts['incrementExpenses'];
			$totalIncrementGuarantee += $convertedAmounts['incrementGuarantee'];
			$totalDiscount += $convertedAmounts['discount'];
			$totalIncrementLock += $convertedAmounts['incrementLock'];
			$totalIncrementMarkup += $convertedAmounts['incrementMarkup'];
			$subTotal += $convertedAmounts['subTotal'];
			$tax  += $convertedAmounts['tax'];  

		}

		$totalLocal = $subTotalLocal + $taxLocal + $totalIncrementExpensesLocal + $totalIncrementGuaranteeLocal
			- $totalDiscountLocal;
		$taxLocal  = round($taxLocal);
		$subTotal = round($subTotal, $round);
		$tax  = round($tax, $round);
		$totalIncrementExpenses = round($totalIncrementExpenses, $round);
		$totalIncrementGuarantee = round($totalIncrementGuarantee, $round);
		$totalDiscount = round($totalDiscount, $round);
		$total = round($subTotal + $tax + $totalIncrementExpenses + $totalIncrementGuarantee - $totalDiscount, $round);

		$reservation
	        ->setReservationDate(new \DateTime('now'))
	       	->setChildNumber($itinerary['cnn'])
        	->setAdultNumber($itinerary['adt'])
        	->setInfNumber($itinerary['inf'])
        	->setInsNumber($itinerary['ins'])
        	->setPublicId()
	        ->setIpAddress($pararms['ipAddress'])
	        ->setOrigin('navicu web');		 

	 	$manager->persist($reservation);
    	$manager->flush();

    	$response['public_id'] = $reservation->getPublicId();
        $response['incrementAmount'] = round($totalIncrementAmount, $round);
        $response['incrementLock'] = round($totalIncrementLock, $round);
        $response['incrementMarkup'] = round($totalIncrementMarkup, $round);
		$response['currencySymbol'] = $params['userCurrency'];
		$response['subtotal'] = $subTotal;
		$response['tax'] = $tax;
		$response['incrementExpenses'] = $totalIncrementExpenses;
		$response['incrementGuarantee'] = $totalIncrementGuarantee;
		$response['discount'] = $totalDiscount;
		$response['total'] = $total;

		return $response;

    }


    private function updateReservationGds(FlightReservationGds $reservationGds, $itinerary, $params, $convertedAmounts) : ?FlightReservationGds
	{

		$manager = $this->container->get('doctrine')->getManager();

		$repAirFrom = $manager->getRepository(Airport::class)->findAllByAirport($itinerary['from']);
		$repAirTo = $manager->getRepository(Airport::class)->findAllByAirport($itinerary['to']);

		$airline = $manager->getRepository(Airline::class)->findOneBy(['iso' => $itinerary['flights'][0]['airline']]);

		if (($repAirFrom[0]['country_code'] !== 'VE') || ($repAirTo[0]['country_code'] !== 'VE')){
			$airlineCommission = $airline->getInternationalCommission();
		}else{
			$airlineCommission = $airline->getNationalCommission();
		}	
        //$today = new \DateTime("now 00:00:00");

        $currency_reservation = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $params['userCurrency']]);
        $currency_gds = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $itinerary['currency']]);


        $reservationGds
        ->setCurrencyGds($currency_gds)
        ->setCurrencyReservation($currency_reservation)	        
        ->setReservationDate(new \DateTime('now'))			
        ->setChildNumber($itinerary['cnn'])
        ->setAdultNumber($itinerary['adt'])
        ->setInfNumber($itinerary['inf'])
        ->setInsNumber($itinerary['ins'])
        ->setSubtotalOriginal($convertedAmounts['originalAmount'])
        ->setSubtotalOriginal($convertedAmounts['originalAmount'] - $itinerary['original_price_no_tax'])
        ->setTaxes($itinerary['taxes'])
        ->setSubtotal($convertedAmounts['subTotal'])
        ->setTax($convertedAmounts['tax'])
        ->setIncrementConsolidator($convertedAmounts['incrementConsolidator'])
        ->setMarkupIncrementAmount($convertedAmounts['incrementMarkup'])
        ->setMarkupIncrementType(1) 
        ->setMarkupCurrency($params['userCurrency'])
        ->setIncrementExpenses($convertedAmounts['incrementExpenses'])
	        ->setIncrementGuarantee($convertedAmounts['incrementGuarantee'])
	        ->setDiscount($convertedAmounts['discount'])
	        ->setAirlineProvider($manager->getRepository(Airline::class)->findOneBy(['iso' => $itinerary['flights'][0]['airline']]))
	        ->setAirlineCommission($airlineCommission)
	        ->setIsRefundable($itinerary['flights'][0]['isRefundable'])
	        ->setStatus(0)
	        ->setGds($manager->getRepository(Gds::class)->findOneBy(['name' => $itinerary['flights'][0]['provider']]));


	        $dollarRates = NavicuCurrencyConverter::getLastRate($itinerary['currency'], new \DateTime('now'));
	        $currencyRates = NavicuCurrencyConverter::getLastRate($params['userCurrency'], new \DateTime('now'));

   
      	$reservationGds->setDollarRateConvertion((CurrencyType::isLocalCurrency($itinerary['currency'])) ? $dollarRates['buy'] : $dollarRates['sell']);
      	$reservationGds->setCurrencyRateConvertion((CurrencyType::isLocalCurrency($params['userCurrency'])) ? $currencyRates['buy'] : $currencyRates['sell']);

      	$manager->persist($reservationGds);
    	$manager->flush();

      	return $reservationGds;

	}



    private function createFlightFromData($flightData) : ?Flight
	{
        /** @var \Navicu\Core\Domain\Model\Entity\AirlineFlightTypeRate $airlineFlightTypeRatePercentage */
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
               // ->setReturnFlight(false)			
				//->setIsRoundtrip($flightData['petitionRoundtrip'])          
				->setSegment($flightData['segment'])
				->setCabin($flightData['cabin'])			
		;	

		/* falta flight Type*/

		/*if ($flightData['lock']) {
			$flight->setFlightLock($flightData['lock']);
		}*/

		$manager->persist($flight);
    	$manager->flush();

		return $flight;
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
        ];
    }



}