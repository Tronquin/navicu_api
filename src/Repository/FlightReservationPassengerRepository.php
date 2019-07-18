<?php

namespace App\Repository;

use App\Entity\FlightReservationPassenger;
use App\Entity\Flight;
use App\Entity\Passenger;
use App\Entity\FlightReservationGds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * se declaran los metodos y funciones que implementan
 * el repositorio de la entidad FlightLockRepository
 *
 * @author Javier Vásquez <jvasquez@navicu.com>
 * @author Currently Working: Javier Vásquez
 * @version 25/11/18
 */

class FlightReservationPassengerRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlightReservationPassenger::class);
    }

    public function getflightByDatePassenger($firstName, $lastName, $departure, $arrival, $from, $to): array
    {
        $now = new \DateTime("now 00:00:00");

        $data = $this->createQueryBuilder('t')
            ->join(Passenger::class, 'p', 'WITH', 'p.id = t.passenger')
            ->join(FlightReservationGds::class, 'frg', 'WITH', 'frg.id = t.flightReservationGds')
            ->join(Flight::class, 'f', 'WITH', 'f.flightReservationGds = frg.id')
            ->where('f.departureTime > :now and p.name = :firstName and p.lastname = :lastName
                    and f.departureTime= :departure and f.airportFrom = :from and frg.status <> 3 ')
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->setParameter('departure', $departure)
            ->setParameter('from', $from)
            ->setParameter('now', $now)
            ->setMaxResults(1000)
            ->getQuery()->getResult();

        return $data;
    } 



}    