<?php

namespace App\Repository;

use App\Entity\Airport;
use App\Entity\CurrencyType;
use App\Entity\ExchangeRateHistory;
use App\Entity\OAuthUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OAuthUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthUser[]    findAll()
 * @method OAuthUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRateHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeRateHistory::class);
    }

    /**
     * Obtiene la tasa navicu compra
     *
     * @param $dateToLookUp
     * @param int $coinId
     * @return array
     */
    public function getLastRateNavicuInBs(string $dateToLookUp, int $coinId) : array
    {
        global $kernel;
        $conn = $kernel->getContainer()->get('doctrine')->getConnection('navicu_v1');
        $today = (new \DateTime())->format('Y-m-d');

        $query = "
            select  consult_1.id as id, 
                case 
                when ( consult_1.date = '{$today}' and consult_1.rate_api is not null and consult_1.percentage_navicu is not null and consult_1.currency_type = ct.id)
                    then              
                    case when consult_1.rate_navicu is null 
                    then
                        consult_1.rate_api - ((consult_1.percentage_navicu * consult_1.rate_api) /100)
                    else 
                        consult_1.rate_navicu
                    end           
                /* Cuando la fecha ingresada es mayor al ultimo registro donde existio el rate_api*/
                else 
                    (select 
                        case 
                        when '{$dateToLookUp}' > consult_1.date
                            then ( 
                                select consult_2.rate_api - ((consult_2.percentage_navicu * consult_2.rate_api) /100)
                                from exchange_rate_history as consult_2
                                where consult_2.rate_api <> 0 and consult_2.currency_type = ct.id
                                order by consult_2.date desc
                                limit 1)
                        else /*Caso que la fecha consultada este dentro de los datos de la BD*/
                            (
                            select consult_3.rate_api - ((consult_1.percentage_navicu * consult_3.rate_api) /100)
                            from exchange_rate_history as consult_3
                            where consult_3.rate_api <> 0 and consult_3.currency_type = ct.id
                            order by consult_3.date desc
                            limit 1)
                        end
                    )
                end as new_rate_navicu
            from exchange_rate_history as consult_1
            join currency_type as ct
            on ct.id = consult_1.currency_type
            where consult_1.date <= '{$dateToLookUp}' and ct.id = {$coinId}
            order by consult_1.date desc
            limit 1";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtiene la tasa navicu venta
     *
     * @param string $dateToLookUp
     * @param int $coinId
     * @return array
     */
    public function getLastRateNavicuSell(string $dateToLookUp, int $coinId)
    {
        global $kernel;
        $today = (new \DateTime())->format('Y-m-d');
        $conn = $kernel->getContainer()->get('doctrine')->getConnection('navicu_v1');

        $query = "
            select
                case
                when ( consult_1.date = '{$today}' and consult_1.rate_api is not null and consult_1.percentage_navicu_sell is not null and consult_1.currency_type = ct.id)
                    then
                    case when consult_1.rate_navicu_sell is null
                    then
                        --((consult_1.percentage_navicu_sell * consult_1.rate_api) /100) - consult_1.rate_api
                        (consult_1.percentage_navicu_sell * consult_1.rate_api) /100
                    else
                        consult_1.rate_navicu_sell
                    end
                /* Cuando la fecha ingresada es mayor al ultimo registro donde existio el rate_api*/
                else
                    (select
                        case
                        when '{$dateToLookUp}' > consult_1.date
                            then (
                                --select ((consult_2.percentage_navicu_sell * consult_2.rate_api) /100) - consult_2.rate_api
                                select (consult_2.percentage_navicu_sell * consult_2.rate_api) /100
                                from exchange_rate_history as consult_2
                                where consult_2.rate_api <> 0 and consult_2.currency_type = ct.id
                                order by consult_2.date desc
                                limit 1)
                        else /*Caso que la fecha consultada este dentro de los datos de la BD*/
                            (
                            select consult_3.rate_navicu_sell
                            from exchange_rate_history as consult_3
                            where consult_3.rate_api <> 0 and consult_3.currency_type = ct.id and consult_3.rate_navicu_sell is not null
                            order by consult_3.date desc
                            limit 1)
                        end
                    )
                end as new_rate_navicu
            from exchange_rate_history as consult_1
            join currency_type as ct
            on ct.id = consult_1.currency_type
            where consult_1.date <= '{$dateToLookUp}' and ct.id = {$coinId}
            order by consult_1.date desc
            limit 1";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Obtiene el ultimo rate api
     *
     * @param string $currency
     * @return array
     */
    public function findByLastDateCurrency(string $currency) : array
    {
        global $kernel;
        $today = (new \DateTime())->format('Y-m-d');
        $conn = $kernel->getContainer()->get('doctrine')->getConnection();

        return $conn->createQueryBuilder()
            ->select('e.*')
            ->from('exchange_rate_history', 'e')
            ->join('e','currency_type','ct', 'e.currency_type=ct.id')
            ->where('ct.active = true and
                e.date <= :today and ct.alfa3 = :currency and e.rate_api is not null
            ')
            ->setParameters(array(
                'today' => $today,
                'currency'=>$currency
            ))
            ->orderBy('e.date',"desc")
            ->setMaxResults(1)
            ->execute()->fetchAll();
    }
}
