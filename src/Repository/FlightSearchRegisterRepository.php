<?php

namespace App\Repository;

use App\Entity\FlightSearchRegister;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FlightSearchRegister|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlightSearchRegister|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlightSearchRegister[]    findAll()
 * @method FlightSearchRegister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightSearchRegisterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlightSearchRegister::class);
    }

//    /**
//     * @return FlightSearchRegister[] Returns an array of FlightSearchRegister objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlightSearchRegister
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
