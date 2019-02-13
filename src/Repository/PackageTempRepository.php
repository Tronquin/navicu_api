<?php

namespace App\Repository;

use App\Entity\PackageTemp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PackageTemp|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageTemp|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageTemp[]    findAll()
 * @method PackageTemp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageTempRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PackageTemp::class);
    }

//    /**
//     * @return PackageTemp[] Returns an array of PackageTemp objects
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
    public function findOneBySomeField($value): ?PackageTemp
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
