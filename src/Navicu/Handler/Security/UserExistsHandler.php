<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Navicu\Handler\BaseHandler;

/**
 * Verifica si existe un usuario
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class UserExistsHandler extends BaseHandler
{
    /**
     * @return array
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();
        $user = $manager->getRepository(FosUser::class)->findOneBy([ 'email' => $params['email'] ]);

        return [
            'exists' => !!$user
        ];
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
            'email' => 'required'
        ];
    }
}        