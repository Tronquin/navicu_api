<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\ExchangeRateHistory;
use App\Entity\FlightReservation;
use App\Entity\Flight;
use App\Entity\FlightReservationGds;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\ConsolidatorService;


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


	    	$flightLockDate = new \DateTime($segment['flights'][0]['departure']);
	        $convertedAmounts = NavicuFlightConverter::calculateFlightAmount($itinerary['price'], $itinerary['currency'],
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

	        	$localAmounts = NavicuFlightConverter::calculateFlightAmount($itinerary['price'], $itinerary['currency'],
	                    [   'iso' => $itinerary['flights'][0]['airline'],
	                        'rate' => $itinerary['flights'][0]['rate'],
	                        'from' => $itinerary['flights'][0]['origin'],
	                        'to' => $itinerary['flights'][0]['destination'],
	                        'departureDate' => $flightLockDate
	                    ],CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
	                    [
	                        'provider' => $params['provider'],
	                        'negotiatedRate' =>  $negotiatedRate,                    
	                    ]
	                );
	        }

	        $repAirFrom = $manager->getRepository(Airport::class)->findAllByAirport($itinerary['from']);
			$repAirTo = $manager->getRepository(Airport::class)->findAllByAirport($itinerary['to']);

			if (($repAirFrom['data'][0]['country_code'] !== 'VE') || ($repAirTo['data'][0]['country_code'] !== 'VE')){
				$airlineCommission = $airline->getInternationalCommission();
			}else{
				$airlineCommission = $airline->getNationalCommission();
			}	
	        //$today = new \DateTime("now 00:00:00");

	        $currency_reservation = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $params['userCurrency']]);
	        $currency_gds = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $itineray['currency']]);

	        $reservationGds
	        ->setCurrencyGds($currency_gds)
	        ->setCurrencyReservation($currency_reservation)	        
	        ->setReservationDate(new \DateTime('now'))			
	        ->setChildNumber($passengers['cnn'])
	        ->setAdultNumber($passengers['adt'])
	        ->setInfNumber($passengers['inf'])
	        ->setInsNumber($passengers['ins'])
	        ->setSubtotalOriginal($convertedAmounts['original_price'])
	        ->setSubtotalOriginal($convertedAmounts['original_price'] - $convertedAmounts['original_price_no_tax'])
	        ->setTaxes($itinerary['taxes'])
	        ->setSubtotal($convertedAmounts['subtotal'])
	        ->setTax($convertedAmounts['tax'])
	        ->setIncrementConsolidator($convertedAmounts['incrementConsolidator'])
	        ->setMarkupIncrementAmount($convertedAmounts['incrementMarkup'])
	        ->setMarkupIncrementType(1) 
	        ->setMarkupCurrency($params['userCurrency'])
	        ->setIncrementExpenses($convertedAmounts['incrementExpenses'])
   	        ->setIncrementGuarantee($convertedAmounts['incrementGuarantee'])
   	        ->setDiscount($convertedAmounts['discount'])
   	        ->setAirlineProvider($itinerary['flights'][0]['airline'])
   	        ->setAirlineCommission($airlineCommission)
   	        ->setIsRefundable()
   	        ->setStatus(0)
   	        ->setGds()
   	        ->setAirlineProvider();

	       /* if (! CurrencyType::isLocalCurrency($itinerary['currency'])) {
	      		$reservation->setDollarRateConvertion();
		    } */
	        
	        // Incrementos en Local
			$totalIncrementExpensesLocal += $generalConditionsLocal['incrementExpenses'];
			$totalIncrementGuaranteeLocal += $generalConditionsLocal['incrementGuarantee'];
			$totalDiscountLocal += $generalConditionsLocal['discount'];
			$subTotalLocal += $generalConditionsLocal['subTotal'];
			$taxLocal  += $generalConditionsLocal['tax'];

	        // Incrementos en moneda del usuario
			$totalIncrementExpenses += $generalConditions['incrementExpenses'];
			$totalIncrementGuarantee += $generalConditions['incrementGuarantee'];
			$totalDiscount += $generalConditions['discount'];
			$totalIncrementAmount += $generalConditions['incrementTypeRate'];
			$totalIncrementLock += $generalConditions['incrementLock'];
			$totalIncrementMarkup += $generalConditions['incrementMarkup'];
			$subTotal += $generalConditions['subTotal'];
			$tax  += $generalConditions['tax'];  

		}

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