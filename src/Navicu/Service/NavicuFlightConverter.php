<?php

namespace App\Navicu\Service;

use App\Entity\CurrencyType;
use App\Entity\FlightLock;
use App\Entity\AirlineFlightTypeRate;
use App\Entity\Flight;
use App\Entity\Consolidator;
use App\Entity\FlightGeneralConditions;
use App\Entity\FlightReservationGds;
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

    public static function calculateFlightAmount($otaAmount, $otaCurrency, array $lockData, $currency ,array $consolidator = []) : array
    {    	
        
        $today = (new \DateTime())->format('Y-m-d');

        if (! $currency || ! $otaCurrency) {
            throw new NavicuException('Currency not found');
        }    
        
        $isRateSell = self::isRateSell($otaCurrency); 
        
        $originalAmount = $otaAmount;

        // se transforma el monto a la moneda del usuario
        $otaAmount = NavicuCurrencyConverter::convert($otaAmount, $otaCurrency ,$currency, $today, $isRateSell); 

        // Calcula el incremento por bloqueo
        $incrementLock = self::calculateIncrementLock($otaAmount, $otaCurrency, $currency, $lockData , $isRateSell);

        // Calcula el incremento por bloqueo
        $incrementConsolidator = self::calculateIncrementConsolidator($otaAmount, $otaCurrency, $currency, $today, $consolidator);

        // Calcula el incremento por markup de aerolinea
        $incrementMarkup = self::calculateIncrementMarkup($otaAmount, $otaCurrency, $currency);
       
        // Subtotal
        $subTotal = $otaAmount + $incrementLock + $incrementMarkup + $incrementConsolidator['amount'];

        // Calcula los gastos de gestion
        $managementExpenses = self::calculateManagementExpenses($otaAmount, $currency, $currency, $isRateSell);

        // Calcula tax
        $tax =  ($incrementLock + $incrementMarkup + $managementExpenses['incrementExpenses']
                      + $managementExpenses['incrementGuarantee'] - $managementExpenses['discount'] + $incrementConsolidator['amount']) * NavicuCurrencyConverter::getTax();        
        return [
            'otaCurrency' => $otaCurrency, // Moneda que envio la ota
            'userCurrency' => $currency, // Moneda que maneja el usuario
            'originalAmount' => $originalAmount, // Monto en la moneda de la ota
            'convertedAmount' => $otaAmount, // Monto convertido a la moneda del usuario
            'incrementLock' => $incrementLock, // Incremento por bloqueo en moneda del usuario
            'incrementConsolidator' => $incrementConsolidator['amount'], // Incremento por comnsolidador para ciertos proveedores
            'incrementConsolidatorType' => $incrementConsolidator['type'], 
            'incrementConsolidatorInc' => $incrementConsolidator['increment'], 
            'incrementMarkup' => $incrementMarkup, // Incremento por markup en moneda del usuario           
            'subTotal' => $subTotal, // Subtotal en moneda del usuario
            'incrementExpenses' => $managementExpenses['incrementExpenses'], // Gastos de gestion en moneda del usuario
            'incrementGuarantee' => $managementExpenses['incrementGuarantee'], // Incremento por garantia en moneda del usuario
            'discount' => $managementExpenses['discount'], // Descuento navicu
            'tax' => $tax, // Impuesto Navicu
        ];
    }

    /**
     * Calcula el incremento por bloqueo
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $lockData array
     * @return float
    */
    public static function calculateIncrementLock($amount, $otaCurrency, $currency, array $lockData, bool $isRateSell) : float
    {
        global $kernel;
        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        $lock = $manager->getRepository(FlightLock::class)->findLock($lockData['iso'], $lockData['rate'], $lockData['from'], $lockData['to'], $lockData['departureDate'], $currency);

        if (! $lock) {
            return 0;
        }

        // Si hay un bloqueo se aplica el incremento
        if ($lock->getIncrementType() === FlightLock::INCREMENT_TYPE_PERCENTAGE) {
            $incrementLock = $amount * ($lock->getIncrementValue() / 100);
        } else {
            $lockCurrency = $lock->getAirlineFlightTypeRate()->getCurrency()->getAlfa3();
            $incrementLock = NavicuCurrencyConverter::convert($lock->getIncrementValue(),$lockCurrency ,$currency, $today, $isRateSell);
        }

        return $incrementLock;
    }

     /**
     * Calcula el incremento por incremento por bloqueo
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $lockData array
     * @return array
     */
    public static function calculateIncrementConsolidator($amount, $otaCurrency, $currency, $date, array $consolidator_array) : array
    {
        global $kernel;
        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        if (count($consolidator_array) > 0 && $consolidator_array['provider'] === FlightReservationGds::PROVIDER_AMADEUS) {   
           
            $consolidator = $manager->getRepository(Consolidator::class)->getFirstConsolidator();

            if (! $consolidator) {
                return 0;
            }

            $type = $consolidator_array['negotiatedRate'] ? $consolidator->getIncrementTypeTarifaNeg() : $consolidator->getIncrementType();
            $increment = $consolidator_array['negotiatedRate'] ? $consolidator->getIncrementTarifaNeg() : $consolidator->getIncrement();

            $valor = 0;

            if ($type === Consolidator::INCREMENT_TYPE_PERCENTAGE) {

                $valor = $amount * ($increment / 100);

            } elseif ($type === Consolidator::INCREMENT_TYPE_USD) {
                $valor = NavicuCurrencyConverter::convert($increment,'USD',$currency, $date, self::isRateSell($otaCurrency));
            }

            return ['amount' => $valor, 'type' => $type, 'increment' => $increment ];
        }

        return ['amount' => $amount, 'type' => Consolidator::INCREMENT_TYPE_USD, 'increment' => 0];;
    }

    /**
     * Calcula el incremento por markup de aerolinea
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $rate
     * @param $iso
     * @return float
     */
    public static function calculateIncrementMarkup($amount, $otaCurrency, $currency) : float
    {         
        global $kernel;
        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();

        $generalConditions = $manager->getRepository(FlightGeneralConditions::class)->findOneById(1); 
        $markup = (CurrencyType::getLocalActiveCurrency()->getAlfa3() === $otaCurrency ? $generalConditions->getMarkupLocal() :
    				$generalConditions->getMarkupDivisa());

        if ($generalConditions) {
            // Si estan configuradas las condiciones generales se aplica el markup
            $incrementMarkup = $amount * ($markup / 100);

            return $incrementMarkup;
        }

        return 0;
    }
	

     /**
     * Calcula el incremento por tarifa
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $airlineIso
     * @param $typeRate
     * @return float
     *
    public static function calculateIncrementTypeRate($manager, $amount, $airlineIso, $typeRate, $otaCurrency, $currency)
    {
        $airlineTypeRate  = $manager->getRepository(AirlineFlightTypeRate::class)->findByAirlineTypeRateAndCurrency($airlineIso, $typeRate, $otaCurrency);

        if (! $airlineTypeRate) {
            return 0;
        }

        // Existe incremento por tarifa
        if ($airlineTypeRate->getIncrementType() === AirlineFlightTypeRate::INCREMENT_TYPE_PERCENTAGE) {
            $incrementTypeRate = $amount * ($airlineTypeRate->getIncrementValue() / 100);
        } else {
            $typeRateCurrency = $airlineTypeRate->getCurrency()->getAlfa3();
            $incrementTypeRate = self::convert($airlineTypeRate->getIncrementValue(), $typeRateCurrency, $rf, self::isRateSell($currency), $currency);
        }

        return $incrementTypeRate;
    }
	*/


	/**
     * Calcula los gastos de gestion
     *
     * @param RepositoryFactoryInterface $rf
     * @param $amount
     * @param $currency
     * @param $toCurrency
     * @return array
     */
    public static function calculateManagementExpenses($amount, $currency ,$toCurrency, $isRateSell) : array
    {
        global $kernel;
        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();
        
        $generalConditions= $manager->getRepository(FlightGeneralConditions::class)->findOneById(1);        
        $today = (new \DateTime())->format('Y-m-d');
        //$isRateSell = self::isRateSell($currency);

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
    public static function isRateSell($currency) : bool
    {
        if (! CurrencyType::isLocalCurrency($currency)) {
            return true;
        }

        return false;
    }


}