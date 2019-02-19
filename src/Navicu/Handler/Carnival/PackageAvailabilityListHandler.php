<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTemp;
use App\Navicu\Handler\BaseHandler;

/**
 * Obtiene un listado de los paquetes para carnaval
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class PackageAvailabilityListHandler extends BaseHandler
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

        $packages = array_map(function (PackageTemp $package) {

            $p = json_decode($package->getContent(), true);
            $p['id'] = $package->getId();
            $p['availability'] = $package->getAvailability();

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
        return [];
    }
}