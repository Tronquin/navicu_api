<?php

namespace App\Navicu\Handler;

/**
 * Prueba de la api
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class TestHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     */
    protected function handler() : array
    {
        return ['Navicu is ok'];
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