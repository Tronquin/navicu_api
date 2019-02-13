<?php

namespace App\Repository;

use App\Entity\PackageTempPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PackageTempPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageTempPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageTempPayment[]    findAll()
 * @method PackageTempPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageTempPaymentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PackageTempPayment::class);
    }

//    /**
//     * @return PackageTempPayment[] Returns an array of PackageTempPayment objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PackageTempPayment
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
