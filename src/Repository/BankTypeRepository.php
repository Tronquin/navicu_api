<?php

namespace App\Repository;

use App\Entity\BankType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * se declaran los metodos y funciones que implementan
 * el repositorio de la entidad FlightLockRepository
 *
 * @author Javier Vásquez <jvasquez@navicu.com>
 * @author Currently Working: Javier Vásquez
 * @version 25/11/18
 */

class BankTypeRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BankType::class);
    }


    public function getListBanksArray($location = 1, $receiver = false)
    {
        $response = [];
        $params = ['locationZone' => $location];

        if ($receiver)
            $params = array_merge($params,['receiver' => $receiver]);
        
        $all = $this->findBy( $params, ['title' => 'ASC']);
        
        foreach ($all as $bank) {
            $response[] = [
                'id' => $bank->getId(),
                'title' => $bank->getTitle()
            ];
        }

        return $response;
    }

}    