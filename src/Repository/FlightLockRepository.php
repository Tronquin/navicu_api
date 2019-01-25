<?php

namespace App\Repository;

use App\Entity\Airline;
use App\Entity\AirlineFlightTypeRate;
use App\Entity\FlightLock;
use App\Entity\FlightTypeRate;
use App\Entity\Airport;
use App\Entity\CurrencyType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * se declaran los metodos y funciones que implementan
 * el repositorio de la entidad FlightLockRepository
 *
 * @author Javier Vásquez <jvasquez@navicu.com>
 * @author Currently Working: Javier Vásquez
 * @version 20/11/18
 */


class FlightLockRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlightLock::class);
    }

 	/**
     * Busca un bloqueo para los siguientes parametros
     *
     * @param $isoAirline, ISO de la aerolinea
     * @param $rate, Tarifa (Y,X,S, etc)
     * @param $from, iata del aeropuerto de origen
     * @param $to, iata del aeropuerto de destino
     * @param $curr, alfa3 de la moneda 
     * @param \DateTime $departureDate, Fecha de partida del vuelo den DateTime
     * @return mixed
     */
    public function findLock($isoAirline, $rate, $from, $to, \DateTime $departureDate, $curr)
    {
        $lock = $this->createQueryBuilder('fl')
            ->join(AirlineFlightTypeRate::class, 'aftr', 'WITH', 'fl.airlineFlightTypeRate = aftr.id')
            ->join(Airline::class, 'a', 'WITH', 'aftr.airline = a.id')
            ->join(FlightTypeRate::class, 'ftr', 'WITH', 'aftr.flightTypeRate = ftr.id')
            ->join(Airport::class, 'ao', 'WITH', 'fl.origin = ao.id')
            ->join(Airport::class, 'ad', 'WITH', 'fl.destiny = ad.id')
            ->join(CurrencyType::class, 'cu', 'WITH', 'aftr.currency = cu.id')
            ->where('a.iso = :iso')->setParameter('iso', $isoAirline)
            ->andWhere('ftr.rate = :rate')->setParameter('rate', $rate)
            ->andWhere('ao.iata = :from')->setParameter('from', $from)
            ->andWhere('ad.iata = :to')->setParameter('to', $to)
            ->andWhere('fl.startDate = :departure')
            ->andWhere('fl.status = 1')
            ->andWhere('cu.alfa3 = :curr')->setParameter('curr',$curr)
            ->setParameter('departure', $departureDate)
            ->getQuery()->getOneOrNullResult();

        return $lock;
    }







}
