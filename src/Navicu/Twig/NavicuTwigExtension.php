<?php

namespace App\Navicu\Twig;

use App\Entity\CurrencyType;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Integra las funciones de navicu a twig
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class NavicuTwigExtension extends AbstractExtension
{
    /**
     * Define las funciones
     *
     * @return array
     */
    public function getFunctions() : array
    {
        return [
            new TwigFunction('getLocalCurrencies', [$this, 'getLocalCurrencies']),
            new TwigFunction('isLocalCurrency', [$this, 'isLocalCurrency']),
            new TwigFunction('isPreviousCurrency', [$this, 'isPreviousCurrency']),
            new TwigFunction('getLocalActiveCurrency', [$this, 'getLocalActiveCurrency']),
            new TwigFunction('getLocalPreviousCurrency', [$this, 'getLocalPreviousCurrency']),
            new TwigFunction('isLocalActiveCurrency', [$this, 'isLocalActiveCurrency']),
            new TwigFunction('getRateReconversion', [$this, 'getRateReconversion']),
        ];
    }

    /**
     * Consulta la moneda local
     *
     * @return CurrencyType
     */
    public function getLocalCurrencies() : CurrencyType
    {
        return CurrencyType::getLocalCurrencies();
    }

    /**
     * Indica si una moneda es de venezuela
     *
     * @param $alpha3
     * @return bool
     */
    public function isLocalCurrency($alpha3) : bool
    {
        return CurrencyType::isLocalCurrency($alpha3);
    }

    /**
     * Indica si una moneda es de venezuela
     *
     * @param $alpha3
     * @return bool
     */
    public function isPreviousCurrency($alpha3) : bool
    {
        return CurrencyType::isLocalPreviousCurrency($alpha3);
    }

    /**
     * Retorna la moneda local activa de venezuela
     * @return CurrencyType
     */
    public function getLocalActiveCurrency() : CurrencyType
    {
        return CurrencyType::getLocalActiveCurrency();
    }

    /**
     * Retorna la moneda local activa de venezuela
     *
     * @return CurrencyType
     */
    public function getLocalPreviousCurrency() : CurrencyType
    {
        return CurrencyType::getLocalPreviousCurrency();
    }

    /**
     * Indica si una moneda es la actual activa en venezuela
     *
     * @param $alfa3
     * @return bool
     */
    public function isLocalActiveCurrency($alfa3) : bool
    {
        return CurrencyType::isLocalActiveCurrency($alfa3);
    }

    /**
     * Devuelve multiplicador de conversion
     *
     * @return float
     */
    public function getRateReconversion() : float
    {
        return CurrencyType::getRateReconversion();
    }
}