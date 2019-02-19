<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTemp;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Actualiza la disponibilidad de los paquetes
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class UpdatePackageAvailabilityHandler extends BaseHandler
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

        foreach ($params['packages'] as $i => $p) {

            /** @var PackageTemp $package */
            $package = $manager->getRepository(PackageTemp::class)->find($p['id']);

            if (! $package) {
                throw new NavicuException(sprintf('Package not found id: %s', $p['id']));
            }

            $content = json_decode($package->getContent(), true);
            $content['price'] = $p['price'];

            $package->setAvailability($p['availability']);
            $package->setContent(json_encode($content));

            $manager->flush();
        }

        return ['packages' => $params['packages']];
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
            'packages' => 'required'
        ];
    }
}