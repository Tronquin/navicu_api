<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTemp;
use App\Entity\PackageTempPayment;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Procesa el pago del paquete
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ProcessPaymentPackageHandler extends BaseHandler
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

        /** @var PackageTemp $package */
        $package = $manager->getRepository(PackageTemp::class)->find($params['packageId']);

        if (! $package) {
            throw new NavicuException('Package not found');
        }

        if ($package->getAvailability() <= 0) {
            throw new NavicuException('Package not available', self::CODE_NOT_AVAILABILITY);
        }

        // TODO cobrar

        // Registra el pago
        $packagePayment = new PackageTempPayment();
        $packagePayment->setContent(json_encode($params['content']));
        $packagePayment->setPackageTemp($package);
        $packagePayment->setStatus(PackageTempPayment::STATUS_ACCEPTED);

        // Descuenta la disponibilidad del paquete
        $package->addPackageTempPayment($packagePayment);
        $package->setAvailability($package->getAvailability() - 1);

        $manager->persist($packagePayment);
        $manager->flush();

        return compact('package');
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
            'packageId' => 'required|numeric',
            'content' => 'required',
            'payments' => 'required',
            'paymentType' => 'required|numeric|between:1,8'
        ];
    }
}