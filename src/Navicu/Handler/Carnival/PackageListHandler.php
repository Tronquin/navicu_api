<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTemp;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\NavicuCurrencyConverter;

/**
 * Obtiene un listado de los paquetes para carnaval
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class PackageListHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $packages = $manager->getRepository(PackageTemp::class)->findAll();
        $params = $this->getParams();

        $packages = array_map(function (PackageTemp $package) use ($params) {

            $p = json_decode($package->getContent(), true);
            $p['availability'] = $package->getAvailability();
            $p['price'] = NavicuCurrencyConverter::convert($p['price'], 'USD', $params['currency']);

            return $p;

        }, $packages);

        return $packages;
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
            'currency' => 'required|regex:/^[A-Z]{3}/'
        ];
    }
}