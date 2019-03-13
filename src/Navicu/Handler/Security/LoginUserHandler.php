<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Autenticacion de usuario
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class LoginUserHandler extends BaseHandler
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
        $encoder = $this->container->get('security.password_encoder');;
        $generator = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $manager = $this->container->get('doctrine')->getManager();

        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['username'], 'username' => $params['username'] ]);

        if (! $encoder->isPasswordValid($user, $params['password'])) {
            throw new NavicuException('Bad Credentials', 400);
        }

        $token = $generator->create($user);

        return compact('token');
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