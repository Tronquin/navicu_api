<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Navicu\Handler\BaseHandler;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Verifica si existe un usuario
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class LoginUserHandler extends BaseHandler
{
    /**
     * @return array
     */
    protected function handler() : array
    {
        $params = $this->getParams(); 
        $encoder = $params['encoder'];
        $generator = $params['generator'];  

        $manager = $this->container->get('doctrine')->getManager();

        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['username'], 'username' => $params['username'] ]);

        if ($encoder->isPasswordValid($user, $params['password'])) {
            $token = $generator->create($user);
        } else {
            new throw new NavicuException("Bad Credentials", 400);            
        }

        return [
            'token' => $token
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
            'password' => 'required',
            'username' => 'required'
        ];
    }
}        