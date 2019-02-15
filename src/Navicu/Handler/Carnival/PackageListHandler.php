<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\CurrencyType;
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
        $packages = $manager->getRepository(PackageTemp::class)->getAvailablePackages();
        $params = $this->getParams();
        /** @var CurrencyType $currency */
        $currency = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $params['currency']]);

        $packages = array_map(function (PackageTemp $package) use ($currency) {

            $p = json_decode($package->getContent(), true);
            $p['id'] = $package->getId();
            $p['availability'] = $package->getAvailability();
            $p['price'] = NavicuCurrencyConverter::convert($p['price'], 'USD', $currency->getAlfa3());
            $p['symbol'] = $currency->getSimbol();

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