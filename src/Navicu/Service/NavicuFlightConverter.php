<?php

namespace App\Navicu\Service;

use App\Entity\CurrencyType;
use App\Entity\FlightGeneralConditions;
use App\Entity\ExchangeRateHistory;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Service\NavicuCurrencyConverter;
/**
 * 
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class NavicuFlightConverter
{

	CONST TAX = 0.16;

    public static function calculateFlightAmount($otaAmount, $otaCurrency, array $lockData, $currency ,array $consolidator = [])
    {
    	if (! $currency || ! $otaCurrency) {
            throw new NavicuException('Currency not found');
        }    

        $today = (new \DateTime())->format('Y-m-d');
        $isRateSell = self::isRateSell($otaCurrency); 

        // se transforma el monto a la moneda del usuario
        $otaAmount = NavicuCurrencyConverter::convert($otaAmount, $otaCurrency ,$currency, $today, $isRateSell); 
        // Calcula el incremento por bloqueo
        $incrementLock = self::calculateIncrementLock($rf, $otaAmount, $currency, $lockData);
        // Calcula los gastos de gestion
        $managementExpenses = self::calculateManagementExpenses($otaAmount, $currency, $currency);

        // Subtotal
        

        return [
            'otaCurrency' => $otaCurrency, // Moneda que envio la ota
            'subTotal' => $subTotal,
            'userCurrency' => $currency, // Moneda que maneja el usuario
            'incrementExpenses' => $managementExpenses['incrementExpenses'], // Gastos de gestion en moneda del usuario
            'incrementGuarantee' => $managementExpenses['incrementGuarantee'], // Incremento por garantia en moneda del usuario
            'discount' => $managementExpenses['discount'] // Descuento navicu
        ] ;  
    }

    /**
     * Calcula el incremento por bloqueo
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $lockData array
     * @return float
    */
    public static function calculateIncrementLock($amount,$currency, array $lockData)
    {
    	$container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        $lock = $manager->getRepository(FlightGLock::class)->findLock($lockData['iso'], $lockData['rate'], $lockData['from'], $lockData['to'], $lockData['departureDate'], $currency);

        if (! $lock) {
            return 0;
        }

        // Si hay un bloqueo se aplica el incremento
        if ($lock->getIncrementType() === FlightLock::INCREMENT_TYPE_PERCENTAGE) {
            $incrementLock = $amount * ($lock->getIncrementValue() / 100);
        } else {
            $lockCurrency = $lock->getAirlineFlightTypeRate()->getCurrency()->getAlfa3();
            $incrementLock = self::convert($lock->getIncrementValue(), $lockCurrency, $rf, self::isRateSell($otaCurrency));
            NavicuCurrencyConverter::convert($lock->getIncrementValue(),$lockCurrency ,$currency, $today, $isRateSell);
        }

        return $incrementLock;
    }
	

	/**
     * Calcula los gastos de gestion
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $currency
     * @param $toCurrency
     * @return array
     */
    public static function calculateManagementExpenses($amount, $currency ,$toCurrency)
    {
        
    	global $kernel;
        /** @var FlightGeneralCondition $generalConditions */
        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();
        $generalConditions= $manager->getRepository(FlightGeneralConditions::class)->findOneById(1);        
        $today = (new \DateTime())->format('Y-m-d');
        $isRateSell = self::isRateSell($currency);

        if (! $generalConditions) {
            return ['incrementExpenses' => 0, 'incrementGuarantee' => 0, 'discount' => 0];
        }

        // Gastos de emision
        if ($generalConditions->getExpenseType() === FlightGeneralConditions::INCREMENT_TYPE_PERCENTAGE) {
            $incrementExpenses = NavicuCurrencyConverter::convert(($amount * ($generalConditions->getExpenseValue() / 100)), $currency ,$toCurrency, $today, $isRateSell);
        } elseif ($generalConditions->getExpenseType() === FlightGeneralConditions::INCREMENT_TYPE_LOCAL) {
            $incrementExpenses = NavicuCurrencyConverter::convert($generalConditions->getExpenseValue(), CurrencyType::getLocalActiveCurrency()->getAlfa3() ,$toCurrency, $today, $isRateSell);
        } elseif ($generalConditions->getExpenseType() === FlightGeneralConditions::INCREMENT_TYPE_USD) {
            $incrementExpenses = NavicuCurrencyConverter::convert($generalConditions->getExpenseValue(), 'USD' ,$toCurrency, $today, $isRateSell);
        } else {
            $incrementExpenses = 0;
        }

        // Garantia
        if ($generalConditions->getGuaranteeType() === FlightGeneralConditions::INCREMENT_TYPE_PERCENTAGE) {
            $incrementGuarantee = NavicuCurrencyConverter::convert(($amount * ($generalConditions->getGuaranteeValue() / 100)), $currency ,$toCurrency, $today, $isRateSell);
        } elseif ($generalConditions->getGuaranteeType() === FlightGeneralConditions::INCREMENT_TYPE_LOCAL) {
            $incrementGuarantee = NavicuCurrencyConverter::convert($generalConditions->getGuaranteeValue(), CurrencyType::getLocalActiveCurrency()->getAlfa3() ,$toCurrency, $today, $isRateSell);
        } elseif ($generalConditions->getGuaranteeType() === FlightGeneralConditions::INCREMENT_TYPE_USD) {
            $incrementGuarantee = NavicuCurrencyConverter::convert($generalConditions->getGuaranteeValue(), 'USD' ,$toCurrency, $today, $isRateSell);
        } else {
            $incrementGuarantee = 0;
        }

        // Descuento
        if ($generalConditions->getDiscountType() === FlightGeneralConditions::INCREMENT_TYPE_PERCENTAGE) {
            $discount = NavicuCurrencyConverter::convert(($amount * ($generalConditions->getDiscountValue() / 100)), $currency ,$toCurrency, $today, $isRateSell);
        } elseif ($generalConditions->getDiscountType() === FlightGeneralConditions::INCREMENT_TYPE_LOCAL) {
            $discount = NavicuCurrencyConverter::convert($generalConditions->getDiscountValue(), CurrencyType::getLocalActiveCurrency()->getAlfa3() ,$toCurrency, $today, $isRateSell);
        } elseif ($generalConditions->getDiscountType() === FlightGeneralConditions::INCREMENT_TYPE_USD) {
            $discount = NavicuCurrencyConverter::convert($generalConditions->getDiscountValue(), 'USD' ,$toCurrency, $today, $isRateSell);
        } else {
            $discount = 0;
        }

        return [
            'incrementExpenses' => $incrementExpenses,
            'incrementGuarantee' => $incrementGuarantee,
            'discount' => $discount
        ];
    }


    /**
     * Indica si se debe usar la tasa de venta para una tarifa
     *
     *
     * @param RepositoryFactoryInterface $rf
     * @param $rate
     * @param $iso
     * @return bool
     */
    public static function isRateSell($currency)
    {
        if (! CurrencyType::isLocalCurrency($currency)) {
            return true;
        }

        return false;
    }


}