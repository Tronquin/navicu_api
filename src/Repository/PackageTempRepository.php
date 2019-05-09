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

    /**
     * Obtiene los paquetes disponibles
     *
     * @return array
     */
    public function getAvailablePackages()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id')
            ->where('p.availability > :availability')
            ->setParameter('availability', 0)
            ->getQuery()
            ->getResult();
    }

    /**
     * Obtiene todos los paquetes
     *
     * @return array
     */
    public function getPackages()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id')
            ->getQuery()
            ->getResult();
    }
}
