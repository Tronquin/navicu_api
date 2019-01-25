<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\Airport;
use App\Entity\FlightReservationPassenger;
use App\Entity\FlightReservation;
use App\Entity\ExchangeRateHistory;
use App\Entity\FlightReservationGds;
use App\Entity\Passenger;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\OtaService;

/**
 * Genera el booking para una reserva
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class BookFlightHandler extends BaseHandler
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

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        if (! ConsolidatorService::hasCreditForReservation($reservation)) {
            /* | Si no tiene credito suficiente para emitir envia nuevamente a
             * | la busqueda, y a su vez notifica por correo a navicu
             * |...............................................................
             */
            ConsolidatorService::sendSellIncompleteNotification($reservation);

            throw new NavicuException('Consolidator has not sufficient credit', BaseHandler::CODE_NOT_AVAILABILITY);
        }


        /** verificar que algun pasajero alla reservado en un laps reciente o ya tenga bolet al destino en la misma fecha **/
        $validFlight = 200;
        $airportRp = $manager->getRepository(Airport::class);
        $ticketRp = $manager->getRepository(FlightReservationPassenger::class);
        $flightReservationRp = $manager->getRepository(FlightReservation::class);
        $lastPassenger = $lastFlight = []; 

        foreach ($reservation->getGdsReservations() as $reservationGds) {

            foreach ($params['passengers'] as $currentPassenger) {
                $lastPassenger = $currentPassenger;
                foreach ($reservationGds->getFlights() as $flight) {
                    $lastFlight = [];
                    $lastFlight['to'] =  $flight->getAirportTo()->getIata();
                    $lastFlight['from'] = $flight->getAirportFrom()->getIata();

                    $passengerNames = explode(' ', $currentPassenger['fullName']);
                    $from = $flight->getAirportFrom();
                    $to = $flight->getAirportTo();

                    $resultTicket = $ticketRp->getflightByDatePassenger(strtoupper($passengerNames[0]), strtoupper($passengerNames[1]),
                        $flight->getDepartureTime(), $flight->getArrivalTime(), $from, $to);

                    if (count($resultTicket) > 0) {
                        $validFlight = BaseHandler::CODE_REPEATED_TICKET;
                        break;
                    } else {
                        $result = $flightReservationRp->getRecentFlightReservation(strtoupper($passengerNames[0]), strtoupper($passengerNames[1]),
                            $flight->getDepartureTime(), $flight->getArrivalTime(), $from, $to);
                        if (count($result) > 0) {
                            $validFlight = BaseHandler::CODE_REPEATED_BOOK;
                            break;
                        }
                    }
                }

                if ($validFlight != 200) {
                    break;
                }
            }
        }    


        if ($validFlight != 200) {

            return [
                'status_code' => $validFlight,
                'message' => 'repeated_reservation',
                'repeated' => [
                       'to' => $lastFlight['to'],
                       'from' => $lastFlight['from'],
                       'name' => $lastPassenger['fullName'] 
                ],
                'reservation' =>[]
            ];
        }
        /** fin de la validacion del boleto repetido **/



        foreach ($reservation->getGdsReservations() as $gdsReservation) {

            if (is_null($gdsReservation->getBookCode())) {
                // Genera el book, solo hago este paso en caso de no poseer book
                $gdsReservation->setBookCode( $this->getBook($gdsReservation) );
            }

            $reservationCurrency = $gdsReservation->getCurrencyReservation();
            $gdsCurrency = $gdsReservation->getCurrencyGds();

            if (! CurrencyType::isLocalCurrency( $reservationCurrency->getAlfa3() )) {
                // Guarda la tasa de conversion con respecto a la moneda de la reserva

                $exchangeRp = $manager->getRepository(ExchangeRateHistory::class);
                $today = (new \DateTime())->format('Y-m-d');

                if ($gdsCurrency->getAlfa3() === 'USD') {
                    $rate = $exchangeRp->getLastRateNavicuSell($today, $gdsCurrency->getId());
                } else {
                    $rate = $exchangeRp->getLastRateNavicuInBs($today, $gdsCurrency->getId());
                }

                if ($gdsReservation->getCurrencyReservation()->getAlfa3() === 'USD') {
                    $gdsReservation->setDollarRateConvertion($rate[0]['new_rate_navicu']);
                } else {
                    $gdsReservation->setCurrencyRateConvertion($rate[0]['new_rate_navicu']);
                }
            }
        }

        // Actualiza la informacion de la reserva
        $reservation->setStatus(FlightReservation::STATE_IN_PROCESS);
        $reservation->setType('WEB');
        $reservation->setReservationDate(new \DateTime());

        foreach ($params['passengers'] as $passengerData) {
            // Guarda la informacion de los pasajeros
            $passenger = $this->createPassengerFromData($passengerData);
            $manager->persist($passenger);
            $manager->flush();

            foreach ($reservation->getGdsReservations() as $gdsReservation) {
                // FlightReservationPassenger es la pivot entre flightReservationGds y Passenger
                // creo la relacion con cada reservationGds
                $flightReservationPassenger = new FlightReservationPassenger();
                $flightReservationPassenger->setStatus(FlightReservationPassenger::STATUS_WITHOUT_TICKET);
                $flightReservationPassenger->setPassenger($passenger);
                $flightReservationPassenger->setFlightReservationGds($gdsReservation);

                $manager->persist($flightReservationPassenger);
                $manager->flush();
            }
        }

        return [
            'status_code' => 200,
            'message' => 'success',
            'repeated' => [],
            'reservation' => compact('reservation')
        ];
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
            'publicId' => 'required',
            'passengers' => 'required',
            'payments' => 'required'
        ];
    }

    /**
     * Genera un book para una reserva
     *
     * @param FlightReservationGds $reservationGds
     * @return string
     */
    private function getBook(FlightReservationGds $reservationGds) : string
    {
        $params = $this->getParams();
        $country = ($alpha3 = $reservationGds->getCurrencyGds()->getAlfa3()) === 'USD' ? 'US' : 'VE';

        $ff = 'false';
        foreach ($reservationGds->getFlightFareFamily() as $fareFamily) {
            if ($fareFamily->getSelected()) {
                $ff = $fareFamily->getName();
            }
        }

        $flights = [];
        foreach ($reservationGds->getFlights() as $flight) {
            $flights[] = [
                'departureAirport' => $flight->getAirportFrom()->getIata(),
                'arrivalAirport' => $flight->getAirportTo()->getIata(),
                'departureDateTime' => $flight->getDepartureTime()->format('Y-m-d H:i:s'),
                'arrivalDateTime' => $flight->getArrivalTime()->format('Y-m-d H:i:s'),
                'airline' => $flight->getAirline()->getIso(),
                'flightNumber' => $flight->getNumber(),
                'rate' => $flight->getTypeRate(),
                'segment' => $flight->getSegment()
            ];
        }

        $response = OtaService::book([
            'country' => $country,
            'currency' => $alpha3,
            'passengers' => $params['passengers'],
            'fareFamily' => $ff,
            'flights'=> $flights,
            'payment'=> $params['payments'][0],
            'provider' => $reservationGds->getGds()->getName()
        ]);

        return $response['bookCode'];
    }

    /**
     * Crea un registro de pasajero
     *
     * @param array $passengerData
     * @return Passenger
     */
    private function createPassengerFromData($passengerData) : Passenger
    {
        $passenger = new Passenger();

        $passengerNames = explode(' ', $passengerData['fullName']);

        $passenger
            ->setName(strtoupper($passengerNames[0]))
            ->setLastname(strtoupper($passengerNames[1]))
            ->setDocumentType($passengerData['docType'])
            ->setDocumentNumber($passengerData['documentNumber'])
            ->setEmail($passengerData['email'])
            ->setPhone($passengerData['phone']);

        return $passenger;
    }
}