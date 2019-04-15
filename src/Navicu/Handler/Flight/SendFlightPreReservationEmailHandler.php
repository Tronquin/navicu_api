<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;

/**
 * Envia el correo de pre confirmacion de la reserva de boleteria
 * con informacion del ticket al cliente
 *
 * @author Emilio Ochoa <cervelliv@gmail.com>
 */
class SendFlightPreReservationEmailHandler extends BaseHandler
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

        //Obtengo la moneda de la reservación
        $currencyReservation =$reservation->getGdsReservations()[0]->getCurrencyReservation();
        //Obtengo la lista de bancos
        $handler = new ListBankHandler();
        $handler->setParam('currency', $currencyReservation->getAlfa3());
        $handler->processHandler();
        $data['nvcBanks'] = $handler->getData()['data']['receptors'];

        // Envia correo a los pasajeros
        $data['amountsInLocalCurrency'] = false;
        $data['sendNavicu'] = false;
        EmailService::send(
            $recipients,
            'Pre-Reserva de boletos - navicu',
            'Email/Flight/flightPreReservationConfirmation.html.twig',
            $data
        );

        // Envia correo a navicu
        $data['amountsInLocalCurrency'] = true;
        $data['sendNavicu'] = true;
        EmailService::sendFromEmailRecipients(
            'flightResume',
            'Pre-Reserva de boletos - navicu',
            'Email/Flight/flightPreReservationConfirmation.html.twig',
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