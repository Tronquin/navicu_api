<?php

namespace App\Repository;

use App\Entity\PaymentError;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PaymentError|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentError|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentError[]    findAll()
 * @method PaymentError[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentErrorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PaymentError::class);
    }

//    /**
//     * @return PaymentError[] Returns an array of PaymentError objects
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
    public function findOneBySomeField($value): ?PaymentError
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
