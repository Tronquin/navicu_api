<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTempPayment;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Indica que se efectuo la reserva en navicu correspondiente a
 * un paquete vendido
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class MarkReservedInNavicuHandler extends BaseHandler
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
        $manager = $this->getDoctrine()->getManager();
        /** @var PackageTempPayment $packagePayment */
        $packagePayment = $manager->getRepository(PackageTempPayment::class)->find($params['paymentId']);

        if (! $packagePayment) {
            throw new NavicuException('Payment not found');
        }

        if ($packagePayment->getStatus() !== PackageTempPayment::STATUS_ACCEPTED) {
            throw new NavicuException('Package is not payed');
        }

        $packagePayment->setStatus(PackageTempPayment::STATUS_RESERVED_IN_NAVICU);
        $manager->flush();

        return compact('packagePayment');
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
            'paymentId' => 'required|numeric'
        ];
    }
}