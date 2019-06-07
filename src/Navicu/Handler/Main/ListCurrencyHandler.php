<?php

namespace App\Navicu\Handler\Main;

use App\Navicu\Handler\BaseHandler;
use App\Entity\CurrencyType;

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
		
        $manager = $this->getDoctrine()->getManager();
        $currency = $manager->getRepository(CurrencyType::class)->findBy(['active'=>true]);

        $response = [];
        $order= [];
        foreach ($currency as $coin) {
            $objCurrency['alpha'] = $coin->getAlfa3();
            $objCurrency['title'] = $coin->getTitle();
            $objCurrency['sym'] = (!empty($coin->getSimbol())) ? $coin->getSimbol() : "";
           
                array_push($response, $objCurrency);
            
           
        }
      
        //Colocando elementos en primera posicion
        $currenctVES = $response[1];
        unset($response[1]);
        $currenctUSD = $response[2];
        unset($response[2]);
        $currenctEUR = $response[3];
        unset($response[3]);
        array_unshift($response, $currenctVES, $currenctUSD, $currenctEUR );
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