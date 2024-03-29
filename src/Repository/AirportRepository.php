<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\OAuthUser;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
* @author Javier Vasquez <jvasquez@jacidi.com>
*/
class AirportRepository extends BaseRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Airport::class);
    }

        /**
     * Busqueda por autocompletado
     *
     * @param $words
     * @return array
     */
    public function findByWords(string $words) : array
    {
        $words = strtolower($words);
        $separatedWords = $this->separateByType($words, []);

        //$tsQuery = $this->getTsQuery($separatedWords['tsQuery'], "vector");

        /*$tsQuery = "(REPLACE(LOWER(name), ' ', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%' or
                    REPLACE(LOWER(city_name), ' ', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%' or 
                    REPLACE(LOWER(iata), ' ', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%' or 
                    REPLACE(LOWER(location_name), ' ', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%')";*/

        $tsQuery = "(REPLACE(REPLACE(LOWER(tags), ' ', ''), ',', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%' or
                    REPLACE(REPLACE(LOWER(country_name), ' ', ''), ',', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%' or
                    REPLACE(REPLACE(LOWER(iata), ' ', ''), ',', '') like "."'%'||"."REPLACE(LOWER('".$words."'), ' ', '')"."||'%')";

        $result = $this->getEntityManager()
            ->getConnection()
            ->query("
                SELECT
                    a.iata,
                    a.location_name,
                    a.name,
                    a.country_name as country,
                    a.location_name as city,
                    a.location_code,
                    a.city_name,
                    a.visible
                FROM web_fligths_autocompleted_view a
                WHERE a.visible is true AND ".$tsQuery. "
                ORDER BY a.name
                LIMIT 10
            ")
            ->fetchAll();

        return $result;
    }


    public function findAllByAirport(string $airport) : array
    {
        $additionalCriteria = (($airport === '') ? 'visible = true' : 'iata= '."'".$airport."'");
        
        return $this->getEntityManager()
            ->getConnection()
            ->query(" 
                SELECT
                    id,
                    iata,
                    name,
                    visible,
                    location_name,
                    location_code,
                    country_name,
                    country_code,
                    city_name,
                    vector
                from web_fligths_autocompleted_view 
                where " . $additionalCriteria . " order by location_name asc")
            
            ->fetchAll();
    }





}
