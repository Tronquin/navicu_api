<?php

namespace App\Repository;

use App\Entity\Consolidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class ConsolidatorRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Consolidator::class);
    }

    /**
     * Obtiene el primer consolidator registrado
     */
    public function getFirstConsolidator()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


}
