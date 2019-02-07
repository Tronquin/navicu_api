<?php

namespace App\Navicu\Handler\SocialServices;

use App\Navicu\Handler\BaseHandler;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Handler realiza el hash de la clave secreta de las apis de redes sociales 
 *
 * @author Ruben Hidalgo <rhidalgo@jacidi.com>
 */

class SocialServiceHandler extends BaseHandler
{ 
 	/** 
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
    	global $kernel;
        $container = $kernel->getContainer();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../../.env');
        $params = $this->getParams();
        
        $facebookSecretProvider = hash_hmac('sha256',$params['token'],getenv('FACEBOOK_SECRET_PROVIDER'));
        $googleSecretProvider = getenv('GOOGLE_SECRET_PROVIDER');
        //dd($facebookProvider);
        $data = [
            'facebookSecretProvider' => $facebookSecretProvider,
            'googleSecretProvider' => $googleSecretProvider,
        ];
        return $data;
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
    protected function validationRules(): array
    {
        return [
        ];
    }

}
