<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\NavicuCurrencyConverter;

/**
 * Resumen de Reservacion de vuelos
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class ResumeReservationHandler extends BaseHandler
{

    /** Alpha3 de las monedas */
    const CURRENCY_DOLLAR = 'USD';
    /**
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $manager = $this->getDoctrine()->getManager();
        $params = $this->getParams();

        $flightsArray = [];
        global $kernel;
        $dir = $kernel->getRootDir() . '/../web/images/airlines/';

        $reservation = $manager->getRepository(FlightReservation::class)->findOneByPublicId($params['public_id']);

        if (is_null($reservation)) {
            throw new NavicuException(\get_class($this) . ': reservation no exist');
        }

        $incrementExpenses =  $incrementExpensesUSD = $incrementExpensesLocal = 0;
        $incrementGuarantee = $incrementGuaranteeUSD = $incrementGuaranteeLocal = 0;
        $discount = $discountUSD = $discountLocal = 0;
        $subTotal = $subTotalLocal = $subTotalUSD = 0;
        $markupIncrementAmount = $incrementConsolidator = $markupIncrementAmountUSD = $incrementConsolidatorUSD = 0;
        $tax = $taxLocal =  $taxUSD = 0;
        $round = $roundLocal = 2;
        $passengers = [];
        $providers = [];
      
  
        foreach ($reservation->getGdsReservations() as $key => $reservationGds) {
           
            $currencyReservation = $reservationGds->getCurrencyReservation();
            if (CurrencyType::isLocalPreviousCurrency($reservationGds->getCurrencyReservation()->getAlfa3())) {
                $roundLocal = 0;
            }

            $currencyRateConvertion = $reservationGds->getCurrencyRateConvertion();
            $currencyRateConvertion = $currencyRateConvertion ?? 0.0;
            /** Montos convertidos a la moneda de la reserva**/
            $subTotal += NavicuCurrencyConverter::convertToRate(
                $reservationGds->getSubtotal(), 
                CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
                $reservationGds->getCurrencyReservation()->getAlfa3(), 
                $reservationGds->getDollarRateConvertion(),
                $currencyRateConvertion);
            $incrementExpenses += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementExpenses(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $incrementGuarantee += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementGuarantee(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $discount += NavicuCurrencyConverter::convertToRate($reservationGds->getDiscount(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $tax += NavicuCurrencyConverter::convertToRate($reservationGds->getTax(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $markupIncrementAmount += NavicuCurrencyConverter::convertToRate($reservationGds->getMarkupIncrementAmount(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $incrementConsolidator += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementConsolidator(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            
            $SubtotalOriginalCurrencyReservation =NavicuCurrencyConverter::convertToRate(
                $reservationGds->getSubtotalOriginal(), 
                $reservationGds->getCurrencyGds()->getAlfa3(), 
                $reservationGds->getCurrencyReservation()->getAlfa3(), 
                $reservationGds->getDollarRateConvertion(),
                $currencyRateConvertion);


            /** Montos convertidos en USD para efectos de información al correo que le llega a navicu **/
            $subTotalUSD += NavicuCurrencyConverter::convertToRate(
                $reservationGds->getSubtotal(), 
                CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
                self::CURRENCY_DOLLAR, 
                $reservationGds->getDollarRateConvertion(),
                $currencyRateConvertion);
            $incrementExpensesUSD += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementExpenses(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), self::CURRENCY_DOLLAR, $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $incrementGuaranteeUSD += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementGuarantee(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), self::CURRENCY_DOLLAR, $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $discountUSD += NavicuCurrencyConverter::convertToRate($reservationGds->getDiscount(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), self::CURRENCY_DOLLAR, $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $taxUSD += NavicuCurrencyConverter::convertToRate($reservationGds->getTax(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), self::CURRENCY_DOLLAR, $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $markupIncrementAmountUSD += NavicuCurrencyConverter::convertToRate($reservationGds->getMarkupIncrementAmount(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), self::CURRENCY_DOLLAR, $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            $incrementConsolidatorUSD += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementConsolidator(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), self::CURRENCY_DOLLAR, $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
            
            $SubtotalOriginalUSD =NavicuCurrencyConverter::convertToRate(
                $reservationGds->getSubtotalOriginal(), 
                $reservationGds->getCurrencyGds()->getAlfa3(), 
                self::CURRENCY_DOLLAR, 
                $reservationGds->getDollarRateConvertion(),
                $currencyRateConvertion);

            /** Montos en moneda local**/
            $subTotalLocal += $reservationGds->getSubtotal();
            $incrementExpensesLocal += $reservationGds->getIncrementExpenses();
            $incrementGuaranteeLocal += $reservationGds->getIncrementGuarantee();
            $discountLocal += $reservationGds->getDiscount();
            $taxLocal +=$reservationGds->getTax();
            
            $providers[] = [
                'provider' => $reservationGds->getGds()->getName(),
                'subtotalOriginal' => round($reservationGds->getSubtotalOriginal(), $round),
                'SubtotalOriginalUSD' => round($SubtotalOriginalUSD, $round),
                'SubtotalOriginalCurrencyReservation' => round($SubtotalOriginalCurrencyReservation, $round),
                'Alfa3'=> $reservationGds->getCurrencyGds()->getAlfa3(),
                'simbol'=> $reservationGds->getCurrencyGds()->getSimbol()
                
            ];
            $bookCode[] = ['bookCode' => $reservationGds->getBookCode()];

            //es un viaje doble one way
            if($key >=1){
                //variable para mostrar ida y vuelta en email
                $isReturn = true;
            }else{
                $isReturn = false;
            }
            $j = $l =0;
          
            foreach( $reservationGds->getFlights() as $key=>$flight) {
                
                $flightsArray[] = [   
                    'time' => $flight->getDepartureTime()->getTimestamp(),                 
                    'departure' => $flight->getDepartureTime()->format('d-m-Y H:i:s'),
                    'departureTime' => $flight->getDepartureTime()->format('h:i a'),
                    'arrival' => $flight->getArrivalTime()->format('d-m-Y H:i:s'),
                    'arrivalTime' => $flight->getArrivalTime()->format('h:i a'),
                    'originCode' => $flight->getAirportFrom()->getIata(),
                    'originCity' => $flight->getAirportFrom()->getLocation()->getTitle(),
                    'originName' => $flight->getAirportFrom()->getName(),
                    'destinationCode' => $flight->getAirportTo()->getIata(),
                    'destinationCity' => $flight->getAirportTo()->getLocation()->getTitle(),
                    'destinationCityId' => $flight->getAirportTo()->getLocation()->getId(),
                    'destinationName' => $flight->getAirportTo()->getName(),
                    'number' => $flight->getNumber(),
                    'airlineCode' => $flight->getAirline()->getIso(),
                    'airlineName' => $flight->getAirline()->getName(),
                    'return' => $flight->getReturnFlight(),
                    'isReturn' => $isReturn,
                    'logo_exists' => file_exists($dir . $flight->getAirline()->getIso() . '.png'),
                    
                ];

                if ($flight->getReturnFlight()) {
                    $itineraryVuelta[$j] = $flightsArray[$key];
                    $j++;
                } else {
                    $itineraryIda[$l] = $flightsArray[$key];
                    $l++;
                }
            }
            foreach( $reservationGds->getFlightReservationPassengers() as $key => $passengerReservation) {

                $passenger = $passengerReservation->getPassenger();
                $found = false;

                foreach ($passengers as $k => $p) {
                    if ($passenger->getId() === $p['id']){
                        $found = true;
                        $passengers[$k]['tickets'][]['number'] = $passengerReservation->getTicket();
                    }
                }

                if (! $found) {

                    $tickets = [];
                    $tickets[0]['number'] = $passengerReservation->getTicket();

                    $passengers[] = [
                        'id' => $passenger->getId(),
                        'firstName' => $passenger->getName(),
                        'lastName' => $passenger->getLastName(),
                        'docType' => $passenger->getDocumentType(),
                        'docNumber' => $passenger->getDocumentNumber(),
                        'email' => $passenger->getEmail(),
                        'phone' => $passenger->getPhone(),
                        'tickets' => $tickets,
                    ];
                }
            }
        }

        foreach ($passengers as $key => $passenger) {
            unset($passengers[$key]['id']);
        }
        
        $subTotal = round($subTotal,$round) ;
        $tax = round($tax, $round);
        $incrementExpenses = round($incrementExpenses, $round);
        $incrementGuarantee = round($incrementGuarantee, $round);
        $discount = round($discount, $round);
        $total = round($subTotal + $tax + $incrementExpenses + $incrementGuarantee - $discount , $round);
        $subTotalPdf = round($subTotal + $incrementExpenses + $incrementGuarantee - $discount , $round);
        $markupIncrementAmount= round($markupIncrementAmount, $round);
        $incrementConsolidator = round($incrementConsolidator, $round);

        //Redondeo a calculos en dolares
        $subTotalUSD =  round($subTotalUSD,$round);
        $taxUSD = round($taxUSD,$round);
        $incrementExpensesUSD = round($incrementExpensesUSD,$round);
        $incrementGuaranteeUSD = round($incrementGuaranteeUSD,$round);
        $discountUSD = round($discountUSD,$round);
        $totalUSD = round($subTotalUSD + $taxUSD + $incrementExpensesUSD + $incrementGuaranteeUSD - $discountUSD,$round);
        $markupIncrementAmountUSD= round($markupIncrementAmountUSD,$round);
        $incrementConsolidatorUSD = round($incrementConsolidatorUSD,$round);

        $subTotalLocal = round($subTotalLocal, $roundLocal) ;
        $taxLocal = round($taxLocal, $roundLocal);
        $incrementExpensesLocal = round($incrementExpensesLocal, $roundLocal);
        $incrementGuaranteeLocal = round($incrementGuaranteeLocal, $roundLocal);
        $discountLocal = round($discountLocal, $roundLocal);
        $totalLocal = round($subTotalLocal + $taxLocal + $incrementExpensesLocal + $incrementGuaranteeLocal - $discountLocal , $roundLocal);

        
        $structure = [
            'currencyLocalAlfa3' => CurrencyType::getLocalActiveCurrency()->getAlfa3(),
            'currencyLocalSimbol' => CurrencyType::getLocalActiveCurrency()->getSimbol(),
            'currencyReservationAlfa3' => $currencyReservation->getAlfa3(),
            'CurrencyReservationSimbol' => $currencyReservation->getSimbol(),
            'cancelationPolicy' => 'No Reembolsable',
            'public_id' => $reservation->getPublicId(),
            'subTotal' => $subTotal,
            'subTotalPdf' => $subTotalPdf,
            'tax' => $tax,
            'totalToPay' => $total,
            'incrementExpenses' => $incrementExpenses,
            'incrementGuarantee' => $incrementGuarantee,
            'discount' => $discount,
            'markupIncrementAmount' => $markupIncrementAmount,
            'incrementConsolidator' => $incrementConsolidator,
            'subTotalLocal' => $subTotalLocal,
            'taxLocal' => $taxLocal,
            'totalToPayLocal' => $totalLocal,
            'incrementExpensesLocal' => $incrementExpensesLocal,
            'incrementGuaranteeLocal' => $incrementGuaranteeLocal,
            'discountLocal' => $discountLocal,
            'numberAdults' => $reservation->getAdultNumber(),
            'numberKids' =>  $reservation->getChildNumber(),
            'confirmationStatus' => $reservation->getConfirmationStatus(),
            'flights' => $flightsArray,
            'payments' => [],
            'passengers' => $passengers,
            'ipAddress' => $reservation->getIpAddress(),
            'origin' => $reservation->getOrigin(),
            'providers' => $providers,
            'subTotalUSD' => $subTotalUSD,
            'taxUSD' => $taxUSD,
            'totalToPayUSD' => $totalUSD,
            'incrementExpensesUSD' => $incrementExpensesUSD,
            'incrementGuaranteeUSD' => $incrementGuaranteeUSD,
            'discountUSD' => $discountUSD,
            'markupIncrementAmountUSD' => $markupIncrementAmountUSD,
            'incrementConsolidatorUSD' => $incrementConsolidatorUSD,
            'dollar_rate_convertion' => $reservationGds->getDollarRateConvertion(),
            'Currency_rate_convertion' => $reservationGds->getCurrencyRateConvertion(),
            'bookCode' => $bookCode
        ];
       /* $flightsArray = [];
        $flightsArray[0] = $itineraryIda[0];
        $flightsArray[0]['destinationCity'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationCity'];
        $flightsArray[0]['destinationName'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationName'];
        $flightsArray[0]['destinationCode'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationCode'];
        $flightsArray[0]['arrival'] = $itineraryIda[sizeof($itineraryIda)-1]['arrival'];

        $flightsArray[0]['extraArrival'] =  null;
        if (substr($flightsArray[0]['departure'], 0, 2)   !== substr($flightsArray[0]['arrival'], 0, 2) ) {
            $flightsArray[0]['extraArrival'] = ' - '.$flightsArray[0]['arrival'];
        }

        if (! empty($itineraryVuelta)) {
            $flightsArray[1] = $itineraryVuelta[0];
            $flightsArray[1]['destinationCity'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['destinationCity'];
            $flightsArray[1]['destinationName'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['destinationName'];
            $flightsArray[1]['destinationCode'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['destinationCode'];
            $flightsArray[1]['arrival'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['arrival'];

            $flightsArray[1]['extraArrival'] =  null;
            if (substr($flightsArray[1]['departure'], 0, 2)   !== substr($flightsArray[1]['arrival'], 0, 2) ) {
                $flightsArray[1]['extraArrival'] = ' - '.$flightsArray[1]['arrival'];
            }
        }

        $orderArray = [];
        foreach ($flightsArray as $clave => $fila) {
            $orderArray[$clave] = $fila['time'];
        }
        \array_multisort($orderArray, SORT_ASC, $flightsArray);
       // $structure['flights'] = $flightsArray;*/

        $payments = [];
        foreach ($reservation->getPayments() as $key => $currentPayment) {
            $payments[$key]['amount'] = $currentPayment->getAmount();
            $payments[$key]['status'] = $currentPayment->getStatus();
            $payments[$key]['holder'] = $currentPayment->getHolder();
            $payments[$key]['holderId'] = $currentPayment->getHolderId();
            $payments[$key]['type'] = $currentPayment->getType();
            $payments[$key]['status'] = $currentPayment->getStatus();
            $payments[$key]['response'] = $currentPayment->getResponse();
        }       

        $structure['payments'] = $payments;
        return $structure;
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
            'public_id' => 'required|min:5'
        ];
    }
}