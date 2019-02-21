<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTempPayment;
use App\Navicu\Handler\BaseHandler;

/**
 * Lista todos los pagos de paquetes para un estatus
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
        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();
        $status = $params['status'] ?? null;
        $payments = $manager->getRepository(PackageTempPayment::class)->findByStatus($status);

        $payments = array_map(function (PackageTempPayment $payment) {

            $dataPayment = json_decode($payment->getContent(), true);
            $dataGeneral = json_decode($payment->getPackageTemp()->getContent(), true);

            $data['status'] = $payment->getStatus();
            $data['title'] = $dataGeneral['title'] . '-' .$dataGeneral['subtitle'];
            $data['name'] = $dataPayment['passengers'][0]['title'] . ' ' . $dataPayment['passengers'][0]['fullName'];
            $data['email'] = $dataPayment['passengers'][0]['email'];
            $data['symbol'] = $dataGeneral['symbol'];
            $data['price'] = $dataGeneral['price'];
            $data['id'] = $payment->getId();

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
        return [
            'status' => 'in:1,2,3,4'
        ];
    }
}