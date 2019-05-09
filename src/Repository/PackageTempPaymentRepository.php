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

    /**
     * Obtiene todos los paquetes para un estatus
     *
     * @param int $status
     * @return PackageTempPayment[]
     */
    public function findByStatus($status = null)
    {
        $qb = $this->createQueryBuilder('ptp')->orderBy('ptp.id', 'DESC');

        if ($status) {
            $qb->where('ptp.status = :status')->setParameter('status', $status);
        }

        return $qb->getQuery()->getResult();
    }
}
