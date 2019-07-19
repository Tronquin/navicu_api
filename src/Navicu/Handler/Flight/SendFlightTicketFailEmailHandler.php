<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Envia el correo cuando el ticket no se genera
 *
 * @author David Pinto <dpinto@jacidi.com>
 */
class SendFlightTicketFailEmailHandler extends BaseHandler
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

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        $recipients = [];
        $passengers = [];
        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            foreach ($gdsReservation->getFlightReservationPassengers() as $flightReservationPassenger) {
                $recipients[] = $flightReservationPassenger->getPassenger()->getEmail();

                $passengers[] = [
                    'firstName' => $flightReservationPassenger->getPassenger()->getName(),
                    'lastName' => $flightReservationPassenger->getPassenger()->getLastName(),
                    'phone' => $flightReservationPassenger->getPassenger()->getPhone(),
                    'email' => $flightReservationPassenger->getPassenger()->getEmail(),
                    'bookCode' => $gdsReservation->getBookCode()
                ];
            }
            break;
        }


        $data = [
            'publicId' => $reservation->getPublicId(),
            'passengers' => $passengers,
            'error' => $params['error'],
            'baseURL' => getenv('DOMAIN')
        ];

        // Envia correo a los pasajeros
        $data['sendNavicu'] = false;
        EmailService::send(
            [$recipients[0]],
            'Ticket Fail',
            'Email/Flight/flightTicketFail.html.twig',
            $data
        );

        // Envia correo a navicu
        $data['sendNavicu'] = true;
        EmailService::sendFromEmailRecipients(
            'flightResume',
            'Ticket Fail',
            'Email/Flight/flightTicketFail.html.twig',
            $data
        );

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
            'publicId' => 'required'
        ];
    }
}