<?php

namespace App\Navicu\Service;

use App\Navicu\Exception\OtaException;
use Symfony\Component\Dotenv\Dotenv;

/**
 * Servicio para interactuar con la api de OTA
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class OtaService
{
    /** Metodos para el request */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    /** Url a los servicios de ota */
    const URL_ONE_WAY = 'oneWay';
    const URL_ROUND_TRIP = 'roundTrip';
    const URL_MULTIPLE = 'multiple';
    const URL_CALENDAR = 'calendar';
    const URL_BOOK = 'book';
    const URL_TICKET = 'issue';
    const URL_TICKET_TEST = 'issue_test';
    const URL_FARE_FAMILY = 'fareFamily';
    const URL_SEAT_MAP = 'seatMap';
    const URL_CANCEL = 'cancel';

    /** Codigos de respuesta de OTA */
    const CODE_SUCCESS = 1;

    /**
     * Hace una busqueda one way en OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function oneWay(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'source' => 'required|regex:/^[A-Z]{3}$/',
            'dest' => 'required|regex:/^[A-Z]{3}$/',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d H:i',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'cabin' => 'required|in:C,F,N,W,Y,ALL',
            'scale' => 'required|numeric|between:0,3',
            'baggage' => 'required|numeric|between:0,2',
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_ONE_WAY, $params);
    }

    /**
     * Hace una busqueda round trip en OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function roundTrip(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'source' => 'required|regex:/^[A-Z]{3}$/',
            'dest' => 'required|regex:/^[A-Z]{3}$/',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'cabin' => 'required|in:C,F,N,W,Y,ALL',
            'scale' => 'required|numeric|min:0|max:3',
            'baggage' => 'required|numeric|between:0,2',
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_ROUND_TRIP, $params);
    }

    /**
     * Hace una busqueda round trip en OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function multiple(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'itinerary' => 'required',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'cabin' => 'required|in:C,F,N,W,Y,ALL',
            'scale' => 'required|numeric|between:0,3',
            'baggage' => 'required|numeric|between:0,2',
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_MULTIPLE, $params);
    }

    /**
     * Hace una busqueda calendar en OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function calendar(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'source' => 'required|regex:/^[A-Z]{3}$/',
            'dest' => 'required|regex:/^[A-Z]{3}$/',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'roundTrip' => 'required|numeric|between:0,1'
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_CALENDAR, $params);
    }

    /**
     * Solicita un book a OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function book(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'passengersData' => 'required',
            'fareFamily' => 'required',
            'flights'=> 'required',
            'payment'=> 'required',
            'provider' => 'required|regex:/^[A-Za-z]+$/'
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_BOOK, $params);
    }

    /**
     * Solicita emision de ticket a OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function ticket(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'PaymentType' => 'required|numeric',
            'BookingID' => 'required|regex:/^[A-Z0-9]{6}$/',
            'provider' => 'required|regex:/^[A-Za-z]+$/'
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_TICKET, $params);
    }

    /**
     * Solicita ticket de prueba a OTA (Kiu)
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function ticketTest(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'PaymentType' => 'required|numeric',
            'BookingID' => 'required|regex:/^[A-Z0-9]{6}$/',
            'Carrier'=>'regex:/^\w{2}$/',
            'provider' => 'required|regex:/^[A-Za-z]+$/'
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_TICKET_TEST, $params);
    }

    /**
     * Obtiene informacion de Fare Family en OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function fareFamily(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'adt' => 'required|numeric|min:1',
            'cnn' => 'required|numeric',
            'inf' => 'required|numeric',
            'ins' => 'required|numeric',
            'itinerary' => 'required',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_FARE_FAMILY, $params);
    }

    /**
     * Obtiene disponibilidad de asiento en un avion desde OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function seatMap(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'provider' => 'required|regex:/^[A-Z]{3}$/',
            'origin' => 'required|regex:/^[A-Z]{3}$/',
            'dest' => 'required|regex:/^[A-Z]{3}$/',
            'date' => 'required|date_format:Y-m-d',
            'airline' => 'required|regex:/^[A-Z0-9]{2}$/',
            'flight' => 'required|numeric',
            'rate' => 'required|regex:/^[A-Z]{1}$/',
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_SEAT_MAP, $params);
    }

    /**
     * Solicita cancelacion de book en OTA
     *
     * @param array $params
     * @return array
     * @throws OtaException
     */
    public static function cancel(array $params) : array
    {
        $validator = new NavicuValidator();
        $validator->validate($params, [
            'country' => 'required|in:VE,US',
            'currency' => 'required|in:VES,USD',
            'pnr'=> 'required|regex:/^[A-Z0-9]{6}$/',
            'provider' => 'required|regex:/^[A-Za-z]+$/'
        ]);

        if ($validator->hasError()) {
            throw new OtaException(sprintf('Error in ota parameters: %s', json_encode($validator->getErrors())));
        }

        return self::send(self::URL_CANCEL, $params);
    }

    /**
     * Envia el request a OTA
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @return array
     * @throws OtaException
     */
    private static function send(string $url, array $params, string $method = self::METHOD_GET) : array
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        $urlBase = getenv('OTA_URL_BASE');
        $url = $urlBase . $url;
        $params['token'] = getenv('OTA_TOKEN');

        $ch = curl_init();

        foreach ($params as $i =>$param) {

            /* -----------------------------------------------------
             * | En caso que uno de los parametro contenga un array
             * | se transforma en JSON para que viaje por la url
             * -----------------------------------------------------
             * ****************************************************/

            if (is_array($param)) {
                $params[$i] = json_encode($param);
            }
        }

        $url = $url . '?' . http_build_query($params);

        if ($method !== self::METHOD_GET) {

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);

        if (! $response) {
            throw new OtaException('Bad request to OTA');
        }

        return $response;
    }
}