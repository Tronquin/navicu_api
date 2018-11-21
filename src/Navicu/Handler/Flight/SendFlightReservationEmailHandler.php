<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Entity\Passenger;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;

/**
 * Envia el correo de confirmacion de la reserva de boleteria
 * con informacion del ticket al cliente
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class SendFlightReservationEmailHandler extends BaseHandler
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

        // TODO get pasajeros de la reserva
        $passengers = [];

        $recipients = [];
        /** @var Passenger $passenger */
        foreach ($passengers as $passenger) {
            $recipients[] = $passenger->getEmail();
        }

        // Envia correo a los pasajeros
        EmailService::send(
            $recipients,
            'Confirmación de la Reserva - navicu.com',
            'Email/Flight/flightReservationConfirmation.html.twig',
            []
        );

        // Envia correo a navicu
        EmailService::sendFromEmailRecipients(
            'flight_resume',
            'Confirmación de la Reserva - navicu.com',
            'Email/Flight/flightReservationConfirmation.html.twig',
            []
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