<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\Airport;
use App\Navicu\Handler\BaseHandler;

/**
 * Autocompletado de boleteria
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class AutocompleteHandler extends BaseHandler
{
    /**
     * Aqui va la logica
     *
     * @return array
     */
    protected function handler() : array
    {
        $manager = $this->getDoctrine()->getManager();
        $params = $this->getParams();

        $airports = $manager->getRepository(Airport::class)->findByWords($params['words']);

        foreach ($airports as &$one) {
            $one['only_city_name'] = $this->upperFirstLetter($one['city_name']);
            $one['city_name'] = $this->upperFirstLetter($one['country']) .", ". $this->upperFirstLetter($one['city_name']);
            $one['completeName'] = $one['iata'].' '. $one['only_city_name'] . ', ' . $one['country'] . ' - ' . $one['name'];
        }

        // Agrupa por pais
        $resultsPerCountry = [];
        foreach ($airports as $two) {

            $resultsPerCountry[ $two['city_name'] ][] = $two;
        }

        // Si no tiene pais o el pais retorna un solo aeropuerto no se agrupa
        $results = [];
        foreach ($resultsPerCountry as $city => $airports) {

            if (empty($city) || count($airports) <= 1) {

                $results[] = [
                    'type' => 'airport',
                    'label' => $airports[0]['completeName'],
                    'code' => $airports[0]['iata'],
                    'data' => $airports[0],
                ];

            } else {
                if (! empty($airports[0]['only_city_name'])) {
                    $results[] = [
                        'type' => 'group',
                        'label' => $city. ' - Todos los aeropuertos',
                        'code' => $airports[0]['iata'],
                        'data' => $airports
                    ];
                } else {
                    foreach ($airports as $key => $airport2) {
                        $results[] = [
                        'type' => 'airport',
                        'label' => $airport2['completeName'],
                        'code' => $airport2['iata'],
                        'data' => $airport2,
                ];
                    }
                }
            }
        }

        return $results;
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
            'words' => 'required|min:3'
        ];
    }

    /**
     * Convierte la palabra en minuscula con las iniciales
     * en mayuscula
     *
     * @param string $text
     * @return string
     */
    private function upperFirstLetter($text)
    {
        $text = strtolower($text);
        $explode = explode(' ', $text);

        $text = '';

        foreach ($explode as $t) {
            $text .= ucfirst($t) . ' ';
        }

        return trim($text);
    }
}