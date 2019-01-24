<?php

namespace App\Navicu\Handler\Flight;

use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;

/**
 * Este handler agrupa todas las funcionalidades necesarias
 * para procesar una reserva en boleteria y notificar al
 * cliente
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ProcessFlightReservationHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
        $params = $this->getParams();

        /*| **********************************************************************
         *| Paso 1:
         *| - Valida que posee credito suficiente en el consolidador
         *| - Si es necesario, envia correo de credito consolidador casi agotado
         *| - Genera el book de la reserva en OTA
         *| - Calcula las tasas de conversion dentro del registro de la reserva
         *| - Cambia el estatus de la reserva
         *| - Guarda la informacion de los pasajeros
         * .......................................................................
         */
        $handler = new BookFlightHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->setParam('passengers', $params['passengers']);
        $handler->setParam('payments', $params['payments']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            $this->addErrorToHandler( $handler->getErrors()['errors'] );

            throw new NavicuException('BookFlightHandler fail', $handler->getCode());
        }

        /*| **********************************************************************
         *| Paso 2:
         *| - Valida que el monto pagado no supere el total de la reserva
         *| - Procesa el pago del cliente
         *| - Registra el pago y lo asocia a la reserva
         *| - Consume el credito de la aerolinea y del consolidador
         * .......................................................................
         */
        $handler = new PayFlightReservationHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->setParam('paymentType', $params['paymentType']);
        $handler->setParam('payments', $params['payments']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {

            $this->addErrorToHandler( $handler->getErrors()['errors'] );

            // En caso de error envia correo de notificacion a navicu
            $this->sendPaymentDeniedEmail($params['publicId']);

            throw new NavicuException('PayFlightReservationHandler fail', $handler->getCode());
        }

        /*| **********************************************************************
         *| Paso 3:
         *| - Genera el ticket en OTA
         *| - Registra los ticket en DB y los asocia a la reserva
         * .......................................................................
         */
        $handler = new IssueTicketHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            $this->addErrorToHandler( $handler->getErrors()['errors'] );

            throw new NavicuException('IssueTicketHandler fail', $handler->getCode());
        }

        $responseData = $handler->getData()['data'];

        /*| **********************************************************************
         *| Paso 4:
         *| - Envia correo de confirmacion a los pasajeros y a navicu
         * .......................................................................
         */
        $handler = new SendFlightReservationEmailHandler();
        $handler->setParam('publicId', $params['publicId']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            // Si falla el correo se notifica a navicu para gestion offline
            $this->sendEmailAlternative($params['publicId']);
        }

        return $responseData;
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
            'paymentType' => 'required|numeric|between:1,3',
            'payments' => 'required',
            'passengers' => 'required'
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

    /**
     * Envia correo alternativo en caso que falle el envio del
     * correo de confirmacion con el numero del ticket al cliente.
     * La intencion es notificar a navicu sobre el fallo y gestionar
     * el envio del numero del ticket, el resto del proceso deberia
     * estar correcto.
     *
     * @param string $publicId
     */
    private function sendEmailAlternative(string $publicId) : void
    {
        EmailService::sendFromEmailRecipients(
            'flightResume',
            'Fallo correo confirmacion de ticket - navicu.com',
            'Email/emailTicketFail.html.twig',
            compact('publicId')
        );
    }

    /**
     * Envia un correo de notificacion a navicu con la informacion
     * de la respuesta de la pasarela de pago
     *
     * @param string $publicId
     */
    private function sendPaymentDeniedEmail(string $publicId) : void
    {
        $handler = new SendFlightDeniedEmailHandler();
        $handler->setParam('publicId', $publicId);
        $handler->processHandler();
    }
}