<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\Flight;
use App\Entity\Airline;
use App\Entity\Airport;
use App\Entity\CurrencyType;
use App\Entity\AirlineFlightTypeRate;
use App\Entity\FlightReservation;
use App\Entity\FlightReservationGDS;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Exception\OtaException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\OtaService;
use App\Navicu\Service\NavicuCurrencyConverter;


/**
 * Resumen de Reservacion de vuelos
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class ResumeReservationHandler extends BaseHandler
{
  
    /**
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();
        $reservation = $manager->getRepository(FlightReservation::class)->findOneByPublicId($params['public_id']);      
        //$response = $this->processStructure($reservation,$params['currency']);

        $countPassengers = $reservation->getChildNumber()+$reservation->getAdultNumber()+ $reservation->getInfNumber() + $reservation->getInsNumber();
        $price = 0;
        $incrementExpenses = 0;
        $incrementGuarantee = 0;
        $discount = 0;
        $round = 0;
        $subTotal = 0;
        $subTotalPdf = 0;
        $tax = 0;
        $total = 0;

        $round = 2;
        if (CurrencyType::isLocalPreviousCurrency($reservation->getCurrencyType()->getAlfa3())) {
            $round = 0;
        } 

        if (CurrencyType::getLocalActiveCurrency()->getAlfa3() !== $reservation->getCurrencyType()->getAlfa3()) {

            foreach ($reservation->getFlightReservationGds() as $reservationGds) {                

                $isRateSell = ($reservationGds->getCurrencyType()->getAlfa3() === 'USD');
                
                $subtotal = NavicuCurrencyConverter::convert($reservation->getSubtotal(), CurrencyType::getLocalActiveCurrency(), $reservation->getCurrency()->getAlfa3(), $reservation->getReservationDate(), $isRateSell);

              

   
        }        


        




            
            

            /*
            $incrementExpenses = NavicuCurrencyConvert::convert($reservation->getIncrementExpenses(), getLocalActiveCurrency() ,$reservation->getCurrency()->getAlfa3() );
            $incrementGuarantee = (($reservation->getIncrementGuarantee() 
            $discount = (($reservation->getDiscount());

            $subTotal = (($reservation->getSubTotalNoExtraIncrement() * $countPassengers) / $rate) * $rateMoney;
            $total = (($flight->getSubTotalNoExtraIncrement() + $flight->getIncrementExpenses() + $flight->getIncrementGuarantee()
                    + $flight->getTaxTotal()  -  $flight->getDiscount()) * $countPassengers / $rate) * $rateMoney;
            $tax = ($flight->getTaxTotal() * $countPassengers/ $rate) * $rateMoney;
            */

        }

        return NULL;
    }

    /**
     * @return array
     * @throws NavicuException
     
    protected function processStructure($reservation )
    {
        $countPassengers = $reservation->getChildNumber()+$reservation->getAdultNumber();
        $price = 0;
        $incrementExpenses = 0;
        $incrementGuarantee = 0;
        $discount = 0;
        $round = 0;
        $subTotal = 0;
        $subTotalPdf = 0;
        $tax = 0;
        $total = 0;
        $exchangeRateRf = $rf->get('ExchangeRateHistory');

        foreach ($reservation->getFlights() as $flight) {

            $round = 2;
            if (CurrencyType::isLocalPreviousCurrency($reservation->getCurrency()->getAlfa3())) {
                $round = 0;
            }

            $rateMoney = 1;
            if (! CurrencyType::isLocalCurrency($reservation->getCurrency()->getAlfa3())) {
                if ($reservation->getCurrency()->getAlfa3() === 'USD') {
                    if ($flight->getOriginalCurrency()->getAlfa3() === 'USD') {
                        $rate = $reservation->getDollarRateSellCovertion();
                    } else {
                        $rate = $reservation->getDollarRateCovertion();
                    }
                } else {
                    if ($flight->getOriginalCurrency()->getAlfa3() === 'USD') {
                        $rate = $reservation->getCurrencyRateSellCovertion();
                    } else {
                        $rate = $reservation->getCurrencyRateCovertion();
                    }
                    if ($reservation->getCurrency()->getAlfa3() != 'EUR') {
                        $rateTmp2 = $exchangeRateRf->findByLastDateCurrency($reservation->getReservationDate(),
                            $reservation->getCurrency()->getAlfa3());
                        $rateMoney = $rateTmp2[0]->getRateApi();
                    }
                }
            } else {
                $rate = 1;
            }

            $price += ($flight->getPrice() / $rate) * $rateMoney;
            $incrementExpenses += (($flight->getIncrementExpenses() * $countPassengers) / $rate) * $rateMoney;
            $incrementGuarantee += (($flight->getIncrementGuarantee() * $countPassengers) / $rate) * $rateMoney;
            $discount += (($flight->getDiscount() * $countPassengers) / $rate) * $rateMoney;
            $subTotal += (($flight->getSubTotalNoExtraIncrement() * $countPassengers) / $rate) * $rateMoney;
            $total += (($flight->getSubTotalNoExtraIncrement() + $flight->getIncrementExpenses() + $flight->getIncrementGuarantee()
                    + $flight->getTaxTotal()  -  $flight->getDiscount()) * $countPassengers / $rate) * $rateMoney;
            $tax += ($flight->getTaxTotal() * $countPassengers/ $rate) * $rateMoney;
        }

        $subTotal = round($subTotal, $round) ;
        $tax = round($tax, $round);
        $incrementExpenses = round($incrementExpenses, $round);
        $incrementGuarantee = round($incrementGuarantee, $round);
        $discount = round($discount, $round);
        $total = round($subTotal + $tax + $incrementExpenses + $incrementGuarantee - $discount , $round);
        $subTotalPdf = round($subTotal + $incrementExpenses + $incrementGuarantee - $discount , $round);

        $structure = [
            'cancelationPolicy' => 'No Reembolsable',
            'public_id' => $reservation->getPublicId(),
            'code' => $reservation->getCode(),
            'subTotal' => $subTotal,
            'subTotalPdf' => $subTotalPdf,
            'tax' => $tax,
            'totalToPay' => $total,
            'incrementExpenses' => $incrementExpenses,
            'incrementGuarantee' => $incrementGuarantee,
            'discount' => $discount,
            'numberAdults' => $reservation->getAdultNumber(),
            'currencySymbol' => $reservation->getCurrency()->getSimbol(),
            'currency' => $reservation->getCurrency()->getAlfa3(),
            'numberKids' =>  $reservation->getChildNumber(),
            'confirmationStatus' => $reservation->getConfirmationStatus(),
            'fligths' => [],
            'passengers' => [],
            'tickets' => [],
        ];

        $flightsArray = [];
        global $kernel;
        $dir = $kernel->getRootDir() . '/../web/images/airlines/';

        $j = 0;
        $l = 0;
        foreach( $reservation->getFlights() as $key=>$flight) {
            $flightsArray[] = [
                'time' => $flight->getDepartureTime()->getTimestamp(),
                'departure' => $flight->getDepartureTime()->format('d-m-Y H:i:s'),
                'departureDate' =>
                    CoreTranslator::getTranslator('backend.general.time.days.'.strtolower($flight->getDepartureTime()->format('l'))).' '
                    .$flight->getDepartureTime()->format('j').' '
                    .CoreTranslator::getTranslator('backend.general.time.months.'.strtolower($flight->getDepartureTime()->format('F'))),
                'departureTime' => $flight->getDepartureTime()->format('h:i a'),
                'departureOriginal' => $flight->getDepartureTime(),
                'arrival' => $flight->getArrivalTime()->format('d-m-Y H:i:s'),
                'arrivalDate' =>
                    CoreTranslator::getTranslator('backend.general.time.days.'.strtolower($flight->getArrivalTime()->format('l'))).' '
                    .$flight->getArrivalTime()->format('j').' '
                    .CoreTranslator::getTranslator('backend.general.time.months.'.strtolower($flight->getArrivalTime()->format('F'))).' ',
                'arrivalTime' => $flight->getArrivalTime()->format('h:i a'),
                'arrivalOriginal' => $flight->getArrivalTime(),
                'originCode' => $flight->getAirportFrom()->getIata(),
                'originCity' => $flight->getAirportFrom()->getLocation()->getTitle(),
                'originName' => $flight->getAirportFrom()->getName(),
                'destinationCode' => $flight->getAirportTo()->getIata(),
                'destinationCity' => $flight->getAirportTo()->getLocation()->getTitle(),
                'destinationCityId' => $flight->getAirportTo()->getLocation()->getId(),
                'destinationCountryCode' => $flight->getAirportTo()->getLocation()->getParent(),
                'destinationName' => $flight->getAirportTo()->getName(),
                'number' => $flight->getNumber(),
                'airlineCode' => $flight->getAirline()->getIso(),
                'airlineName' => $flight->getAirline()->getName(),
                'return' => $flight->getReturnFlight(),
                'roundTrip' => $flight->getIsRoundtrip(),
                'logo_exists' => file_exists($dir . $flight->getAirline()->getIso() . '.png')
            ];

            if ($flight->getReturnFlight()) {
                $itineraryVuelta[$j] = $flightsArray[$key];
                $j++;
            } else {
                $itineraryIda[$l] = $flightsArray[$key];
                $l++;
            }
        }

        $flightsArray = [];
        $flightsArray[0] = $itineraryIda[0];
        $flightsArray[0]['destinationCity'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationCity'];
        $flightsArray[0]['destinationName'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationName'];
        $flightsArray[0]['destinationCode'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationCode'];
        $flightsArray[0]['arrival'] = $itineraryIda[sizeof($itineraryIda)-1]['arrival'];
        $flightsArray[0]['arrivalDate'] = $itineraryIda[sizeof($itineraryIda)-1]['arrivalDate'];

        $flightsArray[0]['extraArrival'] =  null;
        if (substr($flightsArray[0]['departure'], 0, 2)   !== substr($flightsArray[0]['arrival'], 0, 2) ) {
            $flightsArray[0]['extraArrival'] = ' - '.$flightsArray[0]['arrivalDate'];
        }

        if (! empty($itineraryVuelta)) {
            $flightsArray[1] = $itineraryVuelta[0];
            $flightsArray[1]['destinationCity'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['destinationCity'];
            $flightsArray[1]['destinationName'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['destinationName'];
            $flightsArray[1]['destinationCode'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['destinationCode'];
            $flightsArray[1]['arrival'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['arrival'];
            $flightsArray[1]['arrivalDate'] = $itineraryVuelta[sizeof($itineraryVuelta) - 1]['arrivalDate'];

            $flightsArray[1]['extraArrival'] =  null;
            if (substr($flightsArray[1]['departure'], 0, 2)   !== substr($flightsArray[1]['arrival'], 0, 2) ) {
                $flightsArray[1]['extraArrival'] = ' - '.$flightsArray[1]['arrivalDate'];
            }
        }

        $orderArray = [];
        foreach ($flightsArray as $clave => $fila) {
            $orderArray[$clave] = $fila['time'];
        }
        \array_multisort($orderArray, SORT_ASC, $flightsArray);
        $structure['fligths'] = $flightsArray;


        $rppass = $rf->get('FlightTicket');
        $id_r = $reservation->getId();
        foreach($reservation->getPassengers() as $passenger) {

            $slug = strtoupper($passenger->getName());
            $slug = preg_replace('/[^a-zA-Z0-9\s]/i','', $slug);
            $slug = trim($slug);
            $fn = $slug;

            $slug = strtoupper($passenger->getLastName());
            $slug = preg_replace('/[^a-zA-Z0-9\s]/i','', $slug);
            $slug = trim($slug);
            $ln = $slug;

            $oneWay = $rppass->getTicketWay($id_r,$fn,$ln,1);
            $return = $rppass->getTicketWay($id_r,$fn,$ln,2);
            if (!isset($return[0]['number']))
                $return = null;
            else
                $return = $return[0]['number'];

            $structure['passengers'][] = [
                'firstName' => $fn,
                'lastName' => $ln,
                'docType' => $passenger->getDocumentType(),
                'docNumber' => $passenger->getDocumentNumber(),
                'email' => $passenger->getEmail(),
                'phone' => $passenger->getPhone(),
                'oneWay' => isset($oneWay[0]) ? $oneWay[0]['number'] : null,
                'return' => $return
            ];
        }

        $tmpOneNumber = null;
        foreach( $reservation->getTickets() as $ticket) {

            if (($ticket->getFlight()->getIsRoundtrip() && ($ticket->getWay() === 1))) {
                $tmpOneNumber = $ticket->getNumber();
                $tmpNumber = $tmpOneNumber;
            } else if (($ticket->getFlight()->getIsRoundtrip() && ($ticket->getWay() === 2))) {
                $tmpNumber = $tmpOneNumber;
            } else $tmpNumber = $ticket->getNumber();

            $structure['tickets'][] = [
                'firstName' => $ticket->getFirstName(),
                'lastName' => $ticket->getLastName(),
                'number' => $tmpNumber,
                'price' => $ticket->getPrice(),
                'commision' => $ticket->getCommision(),
                'way' => $ticket->getWay()
            ];
        }

        return $structure;
    
    */
    

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
            
        ];
    }
}
