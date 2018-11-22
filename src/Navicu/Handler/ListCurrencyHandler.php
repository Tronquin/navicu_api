<?php

namespace App\Navicu\Handler\Main;


use App\Entity\CurrencyType;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Exception\NavicuException;

/**
 * Listado de monedas
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class ListCurrencyHandler extends BaseHandler
{
    /** 
     * @return array
     * @throws NavicuException
     */

    protected function handler() : array
    {
		$currencyTypeRf = $rf->get('CurrencyType');

		$params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();

        $currency =  $manager->getRepository(CurrencyType::class)->findAllBy(['active'=>true]);
        $response = [];
        foreach ($currency as $coin) {
            $objCurrency['alpha'] = $coin->getAlfa3();
            $objCurrency['title'] = $coin->getTitle();
            $objCurrency['sym'] = (!empty($coin->getSimbol())) ? $coin->getSimbol() : "";
            array_push($response, $objCurrency);
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
        return [
           
        ];
    }
}        