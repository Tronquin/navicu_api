<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTempPayment;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Confirma el pago de un paquete
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ConfirmPaymentPackageHandler extends BaseHandler
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

        /** @var PackageTempPayment $payment */
        $payment = $manager->getRepository(PackageTempPayment::class)->find($params['paymentId']);

        if (! $payment) {
            throw new NavicuException('Payment Package not found');
        }

        $payment->setStatus(PackageTempPayment::STATUS_ACCEPTED);

        // Descuenta la disponibilidad del paquete
        $package = $payment->getPackageTemp();
        $package->setAvailability($package->getAvailability() - 1);

        $manager->flush();

        // TODO send email

        return compact('payment');
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