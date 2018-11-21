<?php

namespace App\Navicu\Service;

use App\Entity\CurrencyType;
use App\Entity\ExchangeRateHistory;
use App\Navicu\Exception\NavicuException;

/**
 * Maneja todas las conversiones de moneda en el sistema
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class NavicuCurrencyConverter
{
    /** Moneda actual de Venezuela */
    const CURRENT_CURRENCY_VE = 'VES';

    /** Alpha3 de las monedas */
    const CURRENCY_DOLLAR = 'USD';

    /**
     * Guarda la ultima tasa calculada para cada moneda. Este array
     * debe contener un historia de todas las tasas consultadas
     * durante el proceso por moneda y fecha.
     *
     * @var array
     */
    private static $lastRate = [];

    /**
     * Array de todas las monedas consultadas durante el proceso
     *
     * @var array
     */
    private static $currencies = [];


     /**
     * Convierte un monto de una moneda a otra
     *
     * @param float $amount, Monto a convertir
     * @param string $currency, Moneda en la cual esta expresado el monto
     * @param string $toCurrency, Moneda a convertir
     * @param float $dollarRate tasa del dollar 
     * @param float $dollarCurrency tasa de la moneda de la reserva
     * @return float
     * @throws NavicuException
     */
    public static function convertToRate(float $amount, string $currency, string $toCurrency, float $dollarRate, float $currencyRate) : float
    {
        //$currency = self::getCurrency($currency);
        //$toCurrency = self::getCurrency($toCurrency);

        if (! $currency || ! $toCurrency) {
            throw new NavicuException('Currency not found');
        }

        if (! $dollarRate || ! $currencyRate) {
            throw new NavicuException('Currency Rate not found');
        }

        if (($currency) === ($toCurrency)) {
            return $amount;
        }

        if ($currency !== self::CURRENCY_DOLLAR) {
            // Si el monto es en bolivares, convierto a dolar
            $amount = $amount / $dollarRate;
        }

        if ($toCurrency !== self::CURRENCY_DOLLAR) {
            // Si el monto es en bolivares, convierto a dolar
            $amount = $amount * $currencyRate;
        }    

        return $amount;
    }


    /**
     * Convierte un monto de una moneda a otra
     *
     * @param float $amount, Monto a convertir
     * @param string $currency, Moneda en la cual esta expresado el monto
     * @param string $toCurrency, Moneda a convertir
     * @param string $date, Fecha de la tasa de conversion
     * @param bool $rateSell, Indica si se usa la tasa de venta, en su defecto la de compra
     * @return float
     * @throws NavicuException
     */
    public static function convert(float $amount, string $currency, string $toCurrency, string $date = null, bool $rateSell = false) : float
    {
        $currency = self::getCurrency($currency);
        $toCurrency = self::getCurrency($toCurrency);

        if (! $currency || ! $toCurrency) {
            throw new NavicuException('Currency not found');
        }

        if (($alpha3 = $currency->getAlfa3()) === ($toAlpha3 = $toCurrency->getAlfa3())) {
            return $amount;
        }

        $date = is_null($date) ? new \DateTime('now') : \DateTime::createFromFormat('Y-m-d', $date);

        if (! $date) {
            throw new NavicuException('Invalid date');
        }

        if ($alpha3 === self::CURRENT_CURRENCY_VE || $toAlpha3 === self::CURRENT_CURRENCY_VE) {
            return self::convertWithBs($amount, $alpha3, $toAlpha3, $date, $rateSell);
        }

        return self::convertWithoutBs($amount, $alpha3, $toAlpha3, $date, $rateSell);
    }

    /**
     * Aplica la conversión de moneda para el caso donde una
     * de ellas, ya sea la moneda actual o la moneda a convertir
     * sea bolivares
     *
     * @param float $amount
     * @param string $currency
     * @param string $toCurrency
     * @param \DateTime $date
     * @param bool $rateSell
     * @return float
     * @throws NavicuException
     */
    private static function convertWithBs(float $amount, string $currency, string $toCurrency, \DateTime $date, bool $rateSell = false) : float
    {
        if ($currency !== self::CURRENT_CURRENCY_VE && $toCurrency !== self::CURRENT_CURRENCY_VE) {
            throw new NavicuException(sprintf('Currency alfa3 must be %s', self::CURRENT_CURRENCY_VE));
        }

        $lastRate = self::getLastRate(self::CURRENCY_DOLLAR, $date);
        $rate = $rateSell ? $lastRate['sell'] : $lastRate['buy'];
        $dollarAmount = $amount;

        if ($currency === self::CURRENT_CURRENCY_VE) {

            // Si el monto es en bolivares, convierto a dolar
            $dollarAmount = $amount / $rate;

        } elseif ($currency !== self::CURRENCY_DOLLAR) {

            // Si el monto no es bolivares ni dolares, convierto a dolares
            $dollarAmount = self::convertWithoutBs($amount, $currency, self::CURRENCY_DOLLAR, $date);
        }

        if ($toCurrency === self::CURRENCY_DOLLAR) {
            // Si el monto se quiere en dolares, ya esta calculado

            return $dollarAmount;
        }

        $lastRateToCurrency = $toCurrency === self::CURRENT_CURRENCY_VE ?
            self::getLastRate(self::CURRENCY_DOLLAR, $date) :
            self::getLastRate($toCurrency, $date);

        $rateToCurrency = $rateSell ? $lastRateToCurrency['sell'] : $lastRateToCurrency['buy'];

        return ($dollarAmount * $rateToCurrency);
    }

    /**
     * Aplica la conversión de moneda para el caso donde ninguna de
     * las monedas sea bolivares
     *
     * @param float $amount
     * @param string $currency
     * @param string $toCurrency
     * @param \DateTime $date
     * @param bool $rateSell
     * @return float
     * @throws NavicuException
     */
    private static function convertWithoutBs(float $amount, string $currency, string $toCurrency, \DateTime $date, bool $rateSell = false) : float
    {
        if ($currency === self::CURRENT_CURRENCY_VE || $toCurrency === self::CURRENT_CURRENCY_VE) {
            throw new NavicuException(sprintf('Currency "%s" not permitted', self::CURRENT_CURRENCY_VE));
        }

        $lastRateCurrency = self::getLastRate($currency, $date);
        $lastRateToCurrency = self::getLastRate($toCurrency, $date);
        $rateCurrency = $rateSell ? $lastRateCurrency['sell'] : $lastRateCurrency['buy'];
        $rateToCurrency = $rateSell ? $lastRateToCurrency['sell'] : $lastRateToCurrency['buy'];

        $dollarAmount = $amount;

        if ($currency !== self::CURRENCY_DOLLAR) {
            // Si el monto es distinto a dolar, convierto a dolar

            $dollarAmount = $amount / $rateCurrency;
        }

        if ($toCurrency === self::CURRENCY_DOLLAR) {
            // Si se quiere llevar a dolar, ya esta calculado

            return $dollarAmount;
        }

        return ($dollarAmount * $rateToCurrency);
    }

    /**
     * Obtiene la ultima tasa para una moneda y fecha
     *
     * @param string $currency
     * @param \DateTime $date
     * @return array
     */
    private static function getLastRate(string $currency, \DateTime $date) : array
    {
        if (isset(self::$lastRate[$currency][$date->format('Y-m-d')])) {

            /* | ***********************************************************
             * | Evito hacer dos veces la misma consulta para la misma moneda
             * | por temas de optmizacion del proceso
             * |.............................................................*/

            return self::$lastRate[$currency][$date->format('Y-m-d')];
        }

        global $kernel;

        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();
        $exchangeRateRepository = $manager->getRepository(ExchangeRateHistory::class);
        $bs = self::getCurrency($currency);

        $buy = $exchangeRateRepository->getLastRateNavicuInBs($date->format('Y-m-d'), $bs->getId());
        $sell = $exchangeRateRepository->getLastRateNavicuSell($date->format('Y-m-d'), $bs->getId());
        $rate = $exchangeRateRepository->findByLastDateCurrency($bs->getAlfa3());

        self::$lastRate[$currency][$date->format('Y-m-d')] = [
            'buy' => (float) $buy[0]['new_rate_navicu'],
            'sell' => (float) $sell[0]['new_rate_navicu'],
            'api' => (float) $rate[0]->getRateApi()
        ];

        return self::$lastRate[$currency][$date->format('Y-m-d')];
    }

    /**
     * Consulta una moneda y guarda en memoria para consultar
     * una sola vez cada moneda durante el proceso
     *
     * @param string $currency
     * @return CurrencyType
     */
    private static function getCurrency(string $currency) : ?CurrencyType
    {
        if (isset(self::$currencies[$currency])) {

            /* | ***********************************************************
             * | Evito hacer dos veces la misma consulta para la misma moneda
             * | por temas de optmizacion del proceso
             * |.............................................................*/

            return self::$currencies[$currency];
        }

        global $kernel;

        $container = $kernel->getContainer();
        $manager = $container->get('doctrine')->getManager();
        $currencyTypeRp = $manager->getRepository(CurrencyType::class);

        $currency = $currencyTypeRp->findOneBy(['alfa3' => $currency, 'active' => true]);

        if (! $currency) {
            return null;
        }

        self::$currencies[$currency->getAlfa3()] = $currency;

        return $currency;
    }
}