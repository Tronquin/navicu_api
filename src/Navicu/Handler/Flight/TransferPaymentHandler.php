<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Registra pagos a una transferencia
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class TransferPaymentHandler extends BaseHandler
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

        // TODO holidays

        $handler = new PayFlightReservationHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->setParam('paymentType', $params['paymentType']);
        $handler->setParam('payments', $params['payments']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            $this->addErrorToHandler( $handler->getErrors()['errors'] );

            throw new NavicuException('PayFlightReservationHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

        $reservation->setStatus(FlightReservation::STATE_IN_PROCESS);
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
            'paymentType' => 'required|in:4,6',
            'publicId' => 'required',
            'payments' => 'required'
        ];
    }

    /**
     * Carga todos los errores a este handler
     *
     * @param array $errors
     */
    private function addErrorToHandler(array $errors) : void
    {
        foreach ($errors as $error) {
            $this->addError($error);
        }
    }
}