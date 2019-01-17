<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\OAuthUser;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
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

        $tsQuery = $this->getTsQuery($separatedWords['tsQuery'], "vector");

        return $this->getEntityManager()
            ->getConnection()
            ->query("
                SELECT
                    a.iata,
                    a.name,
                    a.country_name as country,
                    a.location_name as city,
                    a.location_code,
                    a.city_name
                FROM web_fligths_autocompleted_view a
                WHERE a.visible = TRUE AND ".$tsQuery. "
                LIMIT 10
            ")
            ->fetchAll()
        ;
    }


    public function findAllByAirport(string $airport) : array
    {
        $additionalCriteria = (($airport === null) ? 'visible = true' : 'iata= '."'".$airport."'");
        
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
                    vector
                from web_fligths_autocompleted_view 
                where " . $additionalCriteria . " order by location_name asc")
            
            ->fetchAll();
    }



}
