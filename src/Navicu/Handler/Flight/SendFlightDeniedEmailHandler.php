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
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        $payments = [];
        foreach ($reservation->getPayments() as $currentPayment) {
            $payments[] = [
                'amount' => $currentPayment->getAmount(),
                'status' => $currentPayment->getStatus(),
                'holder' => $currentPayment->getHolder(),
                'holderId' => $currentPayment->getHolderId(),
                'type' => $currentPayment->getType(),
                'response' => json_encode($currentPayment->getResponse(), true),
            ];
        }

        EmailService::sendFromEmailRecipients(
            'reservationDenied',
            'Reserva Denegada - navicu.com',
            'Email/Flight/flightDeniedReservation.html.twig',
            compact('payments')
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