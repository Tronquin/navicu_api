<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;

/**
 * Envia correo para notificar algun error procesar
 * el pago
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class SendFlightDeniedEmailHandler extends BaseHandler
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

        $handler = new ResumeReservationHandler();
        $handler->setParam('public_id', $params['publicId']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            throw new NavicuException('Email data not found');
        }

        EmailService::sendFromEmailRecipients(
            'reservationDenied',
            'Reserva Denegada - navicu.com',
            'Email/Flight/flightDeniedReservation.html.twig',
            $handler->getData()['data']
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