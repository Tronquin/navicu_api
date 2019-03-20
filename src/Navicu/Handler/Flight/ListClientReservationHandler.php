<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Entity\FosUser;
use App\Entity\CurrencyType;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Service\NavicuCurrencyConverter;
use App\Navicu\Handler\BaseHandler;

/**
 * Lista las reservas por usuario y estatus
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ListClientReservationHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->getDoctrine()->getManager();
        /** @var FosUser $user */
        $user = $manager->getRepository(FosUser::class)->findOneBy(['email' => $params['email']]);
        $status = $params['status'];
        if (! $user) {
            throw new NavicuException('User not found');
        }

        $response = [];
        $reservations = $manager->getRepository(FlightReservation::class)->findBy([
            'status' => $status,
            'clientProfile' => $user->getClientProfile()[0]->getId()
        ]);
 
        /** @var FlightReservation $reservation */
        foreach ($reservations as $reservation) {

            $total = 0;
            $subTotal = 0;
            $tax = 0;
            $incrementGuarantee = 0;
            $incrementExpenses = 0;
            $discount = 0;
            $symbol = '';
            $flightsArray = [];
            $bankList = '';
            foreach ($reservation->getGdsReservations() as $gdsReservation) {
                 
                $symbol = $gdsReservation->getCurrencyReservation()->getSimbol();
                $currencyRateConvertion = $gdsReservation->getCurrencyRateConvertion();
                $currencyRateConvertion = $currencyRateConvertion ?? 0.0;
                $total += NavicuCurrencyConverter::convertToRate($gdsReservation->getTotal(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $gdsReservation->getCurrencyReservation()->getAlfa3(), $gdsReservation->getDollarRateConvertion(), $currencyRateConvertion);

                $subTotal += NavicuCurrencyConverter::convertToRate($gdsReservation->getSubtotal(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $gdsReservation->getCurrencyReservation()->getAlfa3(), $gdsReservation->getDollarRateConvertion(), $currencyRateConvertion);

                $tax += NavicuCurrencyConverter::convertToRate($gdsReservation->getTax(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $gdsReservation->getCurrencyReservation()->getAlfa3(), $gdsReservation->getDollarRateConvertion(), $currencyRateConvertion);

                $incrementGuarantee += NavicuCurrencyConverter::convertToRate($gdsReservation->getIncrementGuarantee(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $gdsReservation->getCurrencyReservation()->getAlfa3(), $gdsReservation->getDollarRateConvertion(), $currencyRateConvertion);

                $incrementExpenses += NavicuCurrencyConverter::convertToRate($gdsReservation->getIncrementExpenses(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $gdsReservation->getCurrencyReservation()->getAlfa3(), $gdsReservation->getDollarRateConvertion(), $currencyRateConvertion);

                $discount += NavicuCurrencyConverter::convertToRate($gdsReservation->getDiscount(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $gdsReservation->getCurrencyReservation()->getAlfa3(), $gdsReservation->getDollarRateConvertion(), $currencyRateConvertion);

                foreach( $gdsReservation->getFlights() as $key=>$flight) {
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
                        'return' => $flight->getReturnFlight()
                        
                    ];
                
                }
              
                
            }
            //Obtengo la lista de banco disponible para esa reservación
            $handler = new ListBankHandler();
            $handler->setParam('currency',  $reservation->getGdsReservations()[0]->getCurrencyReservation()->getAlfa3() );
            $handler->processHandler();
            if (! $handler->isSuccess()) {
                $this->addErrorToHandler( $handler->getErrors()['errors'] );

                throw new NavicuException('ListBankHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params'] );
            }
            //si es una reserva pendiente de pago envio los bancos para que el cliente realice el pago
            if($status == FlightReservation::STATE_PRE_RESERVATION)
                $bankList = $handler->getData()['data'];

            //Convirtiendo el monto en la moneda de la reservación
            $response[] = [
                'publicId' => $reservation->getPublicId(),
                'date' => $reservation->getReservationDate()->format('Y-m-d H:i:s'),
                'type' => $reservation->getType(),
                'currency' => $reservation->getGdsReservations()[0]->getCurrencyReservation()->getAlfa3(),
                'code' => '',
                'total' => round($total,2),
                'subTotal' => $subTotal,
                'tax' => $tax,
                'incrementGuarantee' => $incrementGuarantee,
                'incrementExpenses' => $incrementExpenses,
                'discount' => $discount,
                'numberAdults' => $reservation->getAdultNumber(),
                'numberKids' => $reservation->getChildNumber(),
                'currencySymbol' => $symbol,
                'bankList' =>$bankList, 
                'flights' => $flightsArray,
                
            ];
            
        }
        return $response;
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
            'email' => 'required',
            'status' => 'reqired  | in: 0,1,2,3' 
        ];
    }
}