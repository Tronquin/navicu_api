<?php

namespace App\Repository;

use App\Entity\FlightReservation;
use App\Entity\FlightReservationPassenger;
use App\Entity\FlightReservationGds;
use App\Entity\Flight;
use App\Entity\FlightPayment;
use App\Entity\Passenger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
* @author Javier Vasquez <jvasquez@jacidi.com>
*/
class FlightReservationRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlightReservation::class);
    }

    /** función para buscar una reserva segun datos**/
    public function getRecentFlightReservation($firstName, $lastName, $departure, $arrival, $from, $to) {

        $now = new \DateTime("now");
        $now = $now->modify('-12 hour');

        $data = $this->createQueryBuilder('fr')
            ->join(FlightReservationGds::class, 'frg', 'WITH', 'frg.flightReservation = fr.id')
            ->join(Flight::class, 'f', 'WITH', 'f.flightReservationGds = frg.id')
            ->join(FlightReservationPassenger::class, 'frp', 'WITH', 'frp.flightReservationGds = frg.id')
            ->join(Passenger::class, 'p', 'WITH', 'p.id = frp.passenger')
            ->join(FlightPayment::class, 'fp', 'WITH', 'fp.flightReservation = fr.id')
            ->where('upper(p.name) = :firstName and UPPER(p.lastname) = :lastName
                    and f.departureTime= :departure and f.airportFrom = :from and frg.bookCode is not null
                    and fr.reservationDate > :now and fp.state != 2' )
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->setParameter('departure', $departure)
            ->setParameter('from', $from)
            ->setParameter('now', $now)
            ->getQuery()->getResult();

        return $data;
    }


}
