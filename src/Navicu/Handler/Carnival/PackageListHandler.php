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
        $date = (new \DateTime())->format('Y-m-d');

        $packages = array_map(function (PackageTemp $package) use ($currency, $date) {

            $p = json_decode($package->getContent(), true);
            $p['id'] = $package->getId();
            $p['availability'] = $package->getAvailability();
            $p['price'] = NavicuCurrencyConverter::convert($p['price'], 'USD', $currency->getAlfa3(), $date, true);
            $p['symbol'] = $currency->getSimbol();
            $p['width'] = 50;

            return $p;

        }, $packages);

        $packages = $this->adjustPackageWidth($packages);

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

    /**
     * Ajusta el ancho de los paquetes acorde a los paquete
     * disponibles. Si el numero de paquetes al 50% es impar
     * se cambia uno de 100 => 50 para evitar espacios vacios
     * en la vista
     *
     * @param array $packages
     * @return array
     */
    public function adjustPackageWidth(array $packages) : array
    {
        $countPackages = count($packages);

        if ($countPackages > 0 && $countPackages %2 !== 0) {
            // Conteo de paquetes impar
            $packages[$countPackages - 1]['width'] = 100;
        }

        return $packages;
    }
}