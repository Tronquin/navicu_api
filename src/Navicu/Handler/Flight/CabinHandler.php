<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightClass;
use App\Navicu\Handler\BaseHandler;

/**
 * Obtiene el listado de cabinas disponibles
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class CabinHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $cabins = $manager->getRepository(FlightClass::class)->findAll();

        $response = [];
        /** @var FlightClass $cabin */
        foreach ($cabins as $cabin) {
            $response[] = [
                'name' => $cabin->getName(),
                'description' => $cabin->getDescription()
            ];
        }

        return $response;
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