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
    /**
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        $flightsArray = [];
        global $kernel;
        $dir = $kernel->getRootDir() . '/../web/images/airlines/';

        $reservation = $manager->getRepository(FlightReservation::class)->findOneByPublicId($params['public_id']);

        if (is_null($reservation)) {
            throw new NavicuException(\get_class($this) . ': reservation no exist');
        }

        $incrementExpenses = $incrementExpensesLocal = 0;
        $incrementGuarantee = $incrementGuaranteeLocal = 0;
        $discount = $discountLocal = 0;
        $subTotal = $subTotalLocal = 0;
        $tax = $taxLocal = 0;
        $round = $roundLocal = 2;
        $passengers = [];

        foreach ($reservation->getGdsReservations() as $reservationGds) {

            $currencyReservation = $reservationGds->getCurrencyReservation();

            if (CurrencyType::isLocalPreviousCurrency($reservationGds->getCurrencyReservation()->getAlfa3())) {
                $roundLocal = 0;
            }

            /** Montos convertidos a la moneda de la reserva**/
            $subTotal += NavicuCurrencyConverter::convertToRate(
                $reservationGds->getSubtotal(), 
                CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
                $reservationGds->getCurrencyReservation()->getAlfa3(), 
                $reservationGds->getDollarRateConvertion(), 
                $reservationGds->getCurrencyRateConvertion());

            $incrementExpenses += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementExpenses(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $reservationGds->getCurrencyRateConvertion());
            $incrementGuarantee += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementGuarantee(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $reservationGds->getCurrencyRateConvertion());
            $discount += NavicuCurrencyConverter::convertToRate($reservationGds->getDiscount(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $reservationGds->getCurrencyRateConvertion());
            $tax += NavicuCurrencyConverter::convertToRate($reservationGds->getTax(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $reservationGds->getCurrencyRateConvertion());

            /** Montos en moneda local**/
            $subTotalLocal += $reservationGds->getSubtotal();
            $incrementExpensesLocal += $reservationGds->getIncrementExpenses();
            $incrementGuaranteeLocal += $reservationGds->getIncrementGuarantee();
            $discountLocal += $reservationGds->getDiscount();
            $taxLocal +=$reservationGds->getTax();

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

        $subTotalLocal = round($subTotal, $roundLocal) ;
        $taxLocal = round($tax, $roundLocal);
        $incrementExpensesLocal = round($incrementExpenses, $roundLocal);
        $incrementGuaranteeLocal = round($incrementGuarantee, $roundLocal);
        $discountLocal = round($discount, $roundLocal);
        $totalLocal = round($subTotal + $tax + $incrementExpenses + $incrementGuarantee - $discount , $roundLocal);

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
            'subTotalLocal' => $subTotalLocal,
            'taxLocal' => $taxLocal,
            'totalToPayLocal' => $totalLocal,
            'incrementExpensesLocal' => $incrementExpensesLocal,
            'incrementGuaranteeLocal' => $incrementGuaranteeLocal,
            'discountLocal' => $discountLocal,
            'numberAdults' => $reservation->getAdultNumber(),
            'numberKids' =>  $reservation->getChildNumber(),
            'confirmationStatus' => $reservation->getConfirmationStatus(),
            'flights' => [],
            'payments' => [],
            'passengers' => $passengers
        ];

        $flightsArray = [];
        $flightsArray[0] = $itineraryIda[0];
        $flightsArray[0]['destinationCity'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationCity'];
        $flightsArray[0]['destinationName'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationName'];
        $flightsArray[0]['destinationCode'] = $itineraryIda[sizeof($itineraryIda)-1]['destinationCode'];
        $flightsArray[0]['arrival'] = $itineraryIda[sizeof($itineraryIda)-1]['arrival'];

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
        $structure['flights'] = $flightsArray;

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