<?php

namespace App\Repository;

use App\Entity\FlightReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OAuthUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthUser[]    findAll()
 * @method OAuthUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
            ->join(Flight::class, 'f', 'WITH', 'f.reservation = fr.id')
            ->join(Passenger::class, 'p', 'WITH', 'p.reservation = fr.id')
            ->join(FlightPayment::class, 'fp', 'WITH', 'fp.reservation = fr.id')
            ->where('upper(p.name) = :firstName and UPPER(p.lastname) = :lastName
                    and f.departure_time= :departure and f.airport_from = :from and fr.code is not null
                    and fr.reservation_date > :now and fp.state != 2' )
            ->setParameter('firstName', $firstName)
            ->setParameter('lastName', $lastName)
            ->setParameter('departure', $departure)
            ->setParameter('from', $from)
            ->setParameter('now', $now)
            ->getQuery()->getResult();

        return $data;
    }


}
