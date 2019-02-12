<?php

namespace App\Navicu\Handler\Flight;

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

        // TODO holidays

        // Genera el book para apartar la disponibilidad durante el dia
        $handler = new BookFlightHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->setParam('passengers', $params['passengers']);
        $handler->setParam('payments', $params['payments']);

        if (! $handler->isSuccess()) {
            throw new NavicuException('BookFlightHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

        // Registro pago a la reserva
        $handler = new PayFlightReservationHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->setParam('paymentType', $params['paymentType']);
        $handler->setParam('payments', $params['payments']);

        if (! $handler->isSuccess()) {
            throw new NavicuException('BookFlightHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

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
            'paymentType' => 'required|in:4,6,7'
        ];
    }
}