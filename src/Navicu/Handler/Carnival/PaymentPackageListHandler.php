<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTempPayment;
use App\Navicu\Handler\BaseHandler;

/**
 * Lista todos los pagos pendientes de aprobación
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class PaymentPackageListHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $payments = $manager->getRepository(PackageTempPayment::class)->findAll();

        $payments = array_map(function (PackageTempPayment $payment) {

            $data = json_decode($payment->getContent(), true);
            $data['status'] = $payment->getStatus();

            return $data;

        }, $payments);

        return $payments;
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
        return [];
    }
}