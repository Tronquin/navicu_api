<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\OAuthUser;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OAuthUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthUser[]    findAll()
 * @method OAuthUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
                    a.city_name
                FROM web_fligths_autocompleted_view a
                WHERE a.visible = TRUE AND ".$tsQuery. "
                LIMIT 10
            ")
            ->fetchAll()
        ;
    }
}
