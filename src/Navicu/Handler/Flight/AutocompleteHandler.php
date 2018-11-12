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
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        $airports = $manager->getRepository(Airport::class)->findByWords($params['words']);

        foreach ($airports as &$one) {
            $one['city_name'] = $this->upperFirstLetter($one['city_name']);

            $one['completeName'] = $one['iata'].' '.$one['city_name'] . ', ' . $one['country'] . ' - ' . $one['name'];
        }

        // Agrupa por pais
        $resultsPerCountry = [];
        foreach ($airports as $one) {
            $resultsPerCountry[ $one['city_name'] ][] = $one;
        }

        // Si no tiene pais o el pais retorna un solo aeropuerto no se agrupa
        $results = [];
        foreach ($resultsPerCountry as $city => $airports) {

            if (empty($city) || count($airports) <= 1) {

                $results[] = [
                    'type' => 'airport',
                    'data' => $airports[0]
                ];

            } else {
                $results[] = [
                    'type' => 'group',
                    'label' => $city . ' - Todos los aeropuertos',
                    'data' => $airports
                ];
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