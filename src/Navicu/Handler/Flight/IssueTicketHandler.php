<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\AirlineService;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\OtaService;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Genera el ticket para una reserva
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class IssueTicketHandler extends BaseHandler
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
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../../.env');

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        foreach ($reservation->getGdsReservations() as $gdsReservation) {

            $currency = $gdsReservation->getCurrencyGds()->getAlfa3();
            $country = $currency === 'USD' ? 'US' : 'VE';

            if (getenv('APP_ENV') === 'prod') {
                 $response = OtaService::ticket([
                    'country' => $country,
                    'currency' => $currency,
                    'PaymentType' => 1, // Cash Kiu
                    'BookingID' => $gdsReservation->getBookCode(),
                    'provider' => $gdsReservation->getGds()->getName()
                 ]);
            } else {
                 $response = OtaService::ticketTest([
                    'country' => $country,
                    'currency' => $currency,
                    'PaymentType' => 1, // Cash Kiu
                    'BookingID' => $gdsReservation->getBookCode(),
                    'provider' => $gdsReservation->getGds()->getName()
                ]);
            }

            foreach ($response['TicketItemInfo'] as $data) {

                foreach ($gdsReservation->getFlightReservationPassengers() as $flightReservationPassenger) {
                    // A cada pasajero le asigno su numero de ticket

                    $name = $flightReservationPassenger->getPassenger()->getName();
                    $lastName = $flightReservationPassenger->getPassenger()->getLastname();

                    if (
                        $name === $data['GivenName'] &&
                        $lastName === $data['Surname'] &&
                        ! $flightReservationPassenger->hasTicket()
                    ) {

                        $flightReservationPassenger
                            ->setPrice($data['Amount'])
                            ->setCommision($data['Commission'])
                            ->setTicket($data['Ticket'])
                            ->setDate(new \DateTime())
                        ;

                        break;
                    }
                }
            }

            $gdsReservation->setStatus(FlightReservation::STATE_ACCEPTED);
            $manager->flush();
        }

        $reservation->setStatus(FlightReservation::STATE_ACCEPTED);
        $manager->flush();

        // Movimientos en los creditos de aerolinea y consolidador
        ConsolidatorService::setMovementFromReservation($reservation);
        AirlineService::setMovementFromReservation($reservation, '-');

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
    protected function validationRules(): array
    {
        return [
            'publicId' => 'required'
        ];
    }
}