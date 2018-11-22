<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\ExchangeRateHistory;
use App\Entity\FlightReservation;
use App\Entity\FlightReservationGds;
use App\Entity\FlightReservationPassenger;
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

                if ($gdsCurrency->getAlfa3() === 'USD') {
                    $rate = $exchangeRp->getLastRateNavicuSell(new \DateTime(), $gdsCurrency->getId());
                } else {
                    $rate = $exchangeRp->getLastRateNavicuInBs(new \DateTime(), $gdsCurrency->getId());
                }

                if ($gdsReservation->getCurrencyReservation()->getAlfa3() === 'USD') {
                    $gdsReservation->setDollarRateConvertion($rate);
                } else {
                    $gdsReservation->setCurrencyRateConvertion($rate);
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

        return compact('reservation');
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
            'passengers' => 'required'
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
        $country = ($alpha3 = $reservationGds->getCurrencyGds()->getAlfa3()) === 'USD' ? 'US' : 'VE';

        $ff = '';
        foreach ($reservationGds->getFlightFareFamily() as $fareFamily) {
            if ($fareFamily->getSelected()) {
                $ff = $fareFamily->getName();
            }
        }

        $response = OtaService::book([
            'country' => $country,
            'currency' => $alpha3,
            'passengersData' => $reservationGds->getFlightReservation()->getPassengers(),
            'fareFamily' => $ff,
            'flights'=> $reservationGds->getFlights(),
            'payment'=> [],
            'provider' => $reservationGds->getGds()->getName()
        ]);

        return $response['book'];
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
            ->setName($passengerNames[0])
            ->setDocumentType($passengerData['docType'])
            ->setDocumentNumber($passengerData['documentNumber'])
            ->setEmail($passengerData['email'])
            ->setPhone($passengerData['phone']);

        if (isset($passengerNames[1]))
            $passenger->setLastname($passengerNames[1]);

        return $passenger;
    }
}