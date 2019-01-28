<?php

namespace App\Repository;

use App\Entity\AirlineFlightTypeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
* @author Javier Vasquez <jvasquez@jacidi.com>
*/
class AirlineFlightTypeRateRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AirlineFlightTypeRate::class);
    }


     /**
     * Busca una relacion de aerolinea y tarifa
     *
     * @param $iso
     * @param $typeRate
     * @return AirlineFlightTypeRate
     */
    public function findByAirlineAndTypeRate($iso, $typeRate, $curr)
    {
        $valor = $this->createQueryBuilder('aftr')
            ->join(Airline::class, 'a', 'WITH', 'aftr.airline = a.id')
            ->join(FlightTypeRate::class, 'ftr', 'WITH', 'aftr.flightTypeRate = ftr.id')
            ->where('ftr.rate = :rate')->setParameter('rate', $typeRate)
            ->andWhere('a.iso = :iso')->setParameter('iso', $iso)
            ->andWhere('aftr.currency = :curr')->setParameter('curr', $curr)
            ->getQuery()
            ->getResult()
        ;

        return isset($valor[0]) ? $valor[0] : null;
    }


}    