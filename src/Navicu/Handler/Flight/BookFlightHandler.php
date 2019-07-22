<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\FlightReservationPassenger;
use App\Entity\FlightReservation;
use App\Entity\FlightReservationGds;
use App\Entity\Passenger;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\NavicuCurrencyConverter;
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
        $manager = $this->getDoctrine()->getManager();
        $params = $this->getParams();
        $timeLimit = new \DateTime('now');
        $timeLimit = $timeLimit->modify('+2 hours');
        //$timeLimit = $timeLimit->format('Y-m-d H:i:s');
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

                    $from = $flight->getAirportFrom();
                    $to = $flight->getAirportTo();

                    $resultTicket = $ticketRp->getflightByDatePassenger(
                        strtoupper($currentPassenger['firstName']), strtoupper($currentPassenger['lastName']),
                        $flight->getDepartureTime(), $flight->getArrivalTime(), $from, $to);

                    if (count($resultTicket) > 0) {
                        $validFlight = BaseHandler::CODE_REPEATED_TICKET;
                        break;
                    } else {
                        $result = $flightReservationRp->getRecentFlightReservation(
                            strtoupper($currentPassenger['firstName']), strtoupper($currentPassenger['lastName']),
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
            $repeated = [
                'to' => $lastFlight['to'],
                'from' => $lastFlight['from'],
                'firstName' => $lastPassenger['firstName'],
                'lastName' => $lastPassenger['lastName']
            ];

            throw new NavicuException('RepeatReservation', $validFlight, $repeated);

        }

        /** fin de la validacion del boleto repetido **/


        foreach ($reservation->getGdsReservations() as $gdsReservation) {

            $dollarRates = NavicuCurrencyConverter::getLastRate('USD', new \DateTime());
            $alpha3CurrencyGds = $gdsReservation->getCurrencyGds()->getAlfa3();
            $dollarRate = CurrencyType::isLocalCurrency($alpha3CurrencyGds) ? $dollarRates['buy'] : $dollarRates['sell'];

            if ($dollarRate <> $gdsReservation->getDollarRateConvertion()) {
                // Valida si existe cambios en la tasa del dollar
                throw new NavicuException('Change in dollar rate', self::CODE_NOT_AVAILABILITY);
            }

            if (is_null($gdsReservation->getBookCode())) {
                // Genera el book, solo hago este paso en caso de no poseer book
                $gdsReservation->setBookCode( $this->getBook($gdsReservation) );
            }

        }

        // Actualiza la informacion de la reserva
        $reservation->setStatus(FlightReservation::STATE_IN_PROCESS);
        $reservation->setType('WEB');
        $reservation->setReservationDate(new \DateTime());
        $reservation->setExpireDate($timeLimit);




        foreach ($params['passengers'] as $passengerData) {
            // Guarda la informacion de los pasajeros
            $passenger = $this->createPassengerFromData($passengerData);
            $manager->persist($passenger);
            $manager->flush();

            foreach ($reservation->getGdsReservations() as $gdsReservation) {

                // Limpia los pasajeros
                $flightReservationPassengers = $manager->getRepository(FlightReservationPassenger::class)->findBy(['flightReservationGds' => $gdsReservation]);
                foreach ($flightReservationPassengers as $frp) {
                    $manager->remove($frp);
                    $manager->flush();
                }

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

        $bookingGo = $reservation->getGdsReservations()[0]->getBookCode();
        $bookingReturn = isset($reservation->getGdsReservations()[1]) ?
            $reservation->getGdsReservations()[1]->getBookCode() :
            null
        ;

        return compact('reservation', 'bookingGo', 'bookingReturn');
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

        $passengersData = $this->formatPassengerData($params['passengers']) ;

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
                'segment' => $flight->getSegment(),
                'provider'=> $reservationGds->getGds()->getName()
            ];
        }


        $response = OtaService::book([
            'country' => $country,
            'currency' => $alpha3,
            'passengers' => $passengersData,
            'fareFamily' => $ff,
            'flights'=> $flights,
            'payment'=> $params['payments'][0] ?? [],
            'provider' => $reservationGds->getGds()->getName()
        ]);


        return $response['bookCode'];
    }

    private function formatPassengerData($passengerData) : array  {

        foreach ($passengerData as &$passenger) {
            $passenger['firstName'] = str_replace('á', 'a',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('Á', 'A',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('é', 'e',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('É', 'E',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('í', 'i',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('Í', 'I',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('ó', 'o',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('Ó', 'O',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('ú', 'u',  $passenger['firstName']);
            $passenger['firstName'] = str_replace('Ú', 'U',  $passenger['firstName']);

            $passenger['lastName'] = str_replace('á', 'a',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('Á', 'A',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('é', 'e',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('É', 'E',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('í', 'i',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('Í', 'I',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('ó', 'o',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('Ó', 'O',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('ú', 'u',  $passenger['lastName']);
            $passenger['lastName'] = str_replace('Ú', 'U',  $passenger['lastName']);
        }

        return $passengerData;
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

        $passenger
            ->setName($passengerData['firstName'])
            ->setLastname($passengerData['lastName'])
            ->setDocumentType($passengerData['type'])
            ->setDocumentNumber($passengerData['documentNumber'])
            ->setEmail($passengerData['email'])
            ->setPhone($passengerData['phone']);

        return $passenger;
    }
}