<?php

namespace App\Repository;

use App\Entity\FlightReservationPassenger;
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


    public function getflightByDatePassenger($firstName, $lastName, $departure, $arrival, $from, $to)  
    {
        $now = new \DateTime("now 00:00:00");

        $data = $this->createQueryBuilder('t')
            ->join(Flight::class, 'f', 'WITH', 'f.id = t.flight')
            ->where('f.departure_time > :now and t.firstName = :firstName and t.lastName = :lastName
                    and f.departure_time= :departure and f.airport_from = :from')
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