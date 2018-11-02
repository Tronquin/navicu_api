<?php

namespace App\Repository;

use App\Entity\OAuthUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OAuthUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthUser[]    findAll()
 * @method OAuthUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OAuthUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OAuthUser::class);
    }
}
