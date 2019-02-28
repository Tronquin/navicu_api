<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
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

        $recipients = [];
        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            foreach ($gdsReservation->getFlightReservationPassengers() as $flightReservationPassenger) {
                $recipients[] = $flightReservationPassenger->getPassenger()->getEmail();
            }
            break;
        }
       
        $handler = new ResumeReservationHandler();
        $handler->setParam('public_id', $params['publicId']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            throw new NavicuException('Email data not found');
        }

        $data = $handler->getData()['data'];

        // Envia correo a los pasajeros
        $data['amountsInLocalCurrency'] = false;
        $data['sendNavicu'] = false;
        EmailService::send(
            $recipients,
            'Confirmación de la Reserva - navicu.com',
            'Email/Flight/flightReservationConfirmation.html.twig',
            $data
        );

        // Envia correo a navicu
        $data['amountsInLocalCurrency'] = true;
        $data['sendNavicu'] = true;
        EmailService::sendFromEmailRecipients(
            'flightResume',
            'Confirmación de la Reserva - navicu.com',
            'Email/Flight/flightReservationConfirmation.html.twig',
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