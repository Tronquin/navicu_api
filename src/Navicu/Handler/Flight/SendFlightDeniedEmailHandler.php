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

        //Verifico si viene de reserva cancelada o por fallo de Pago para cambiar el asunto
        if($params['PaymentDenied']){
            $subject =  'Reserva Denegada - navicu.com';
        }else{
            $subject =  'Reserva Cancelada - navicu.com';
        }
         // Envia correo a los pasajeros
         $data['amountsInLocalCurrency'] = false;
         $data['sendNavicu'] = false;
        EmailService::send(
            $recipients,
            $subject,
            'Email/Flight/flightDeniedReservation.html.twig',
            $data
        );
        // Envia correo a navicu
        $data['amountsInLocalCurrency'] = true;
        $data['sendNavicu'] = true;
        EmailService::sendFromEmailRecipients(
            $subject,
            'Reserva Denegada - navicu.com',
            'Email/Flight/flightDeniedReservation.html.twig',
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
            'publicId' => 'required',
            'PaymentDenied' => 'required'
        ];
    }
}