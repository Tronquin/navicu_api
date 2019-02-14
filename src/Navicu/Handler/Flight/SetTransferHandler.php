<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Indica que una reserva se paga por transferencia
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class SetTransferHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();
        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId'] ]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        // Genera el book para apartar la disponibilidad durante el dia
        $handler = new BookFlightHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->setParam('passengers', $params['passengers']);
        $handler->setParam('payments', $params['payments'] ?? []);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            $this->addErrorToHandler( $handler->getErrors()['errors'] );

            throw new NavicuException('BookFlightHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

        $reservation->setStatus(FlightReservation::STATE_PRE_RESERVATION);
        $manager->flush();

        return $handler->getData()['data'];
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
    protected function validationRules() : array
    {
        return [
            'publicId' => 'required',
            'passengers' => 'required'
        ];
    }
}