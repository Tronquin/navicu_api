<?php

namespace App\Navicu\Service;

use App\Navicu\Exception\OtaException;
use Symfony\Component\Dotenv\Dotenv;


/**
 * Servicio para interactuar con la api de OTA
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class RedSocialService
{
	/** Metodos para el request */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    /** Url a los servicios de red Social */
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';

    /**
     * Validar un token de facebook
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function validTokenFacebook(array $params) : array
    {
		$dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        $url = 'https://graph.facebook.com/debug_token';
        $paramsUrl = [];
        $paramsUrl['input_token'] = $params['input_token'];
        $paramsUrl['access_token'] = getenv('FACEBOOK_SECRET_PROVIDER');

        $response = self::send($url, $paramsUrl);

        return $response;
    }


    /**
     * obtener email y nombre de token facebook
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function getDataFacebook(array $params) : array
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        $url = 'https://graph.facebook.com/' . $params['user_id'];
        $paramsUrl = [];
        $paramsUrl['fields'] = 'email';
        $paramsUrl['access_token'] = $params['input_token'];
        $response = self::send($url, $paramsUrl);

        return $response;
    }


    /**
     * obtener email y nombre de token google
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function getDataGoogle(array $params) : array
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        $url = 'https://www.googleapis.com/oauth2/v1/tokeninfo';        
        $paramsUrl = [];
        $paramsUrl['access_token'] = $params['access_token'];
        $response = self::send($url, $paramsUrl);

        return $response;
    }

	/**
     * Envia el request a la Api red social correspondiete
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return array
     * @throws OtaException
     */
    private static function send(string $url, array $params, string $method = self::METHOD_GET) : array
    {
        $ch = curl_init();
        $url = $url . '?' . http_build_query($params);
        if ($method !== self::METHOD_GET) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);

        return $response;
    }

}