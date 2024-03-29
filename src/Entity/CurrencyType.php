<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyType
 *
 * @ORM\Table(name="currency_type")
 * @ORM\Entity
 */
class CurrencyType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="currency_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alfa3", type="string", length=3, nullable=true)
     */
    private $alfa3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="simbol", type="string", length=255, nullable=true)
     */
    private $simbol;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var int|null
     *
     * @ORM\Column(name="round", type="integer", nullable=true)
     */
    private $round;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zero_decimal_base", type="integer", nullable=true, options={"default"="100"})
     */
    private $zeroDecimalBase = '100';

    /**
     * @var bool
     *
     * @ORM\Column(name="local_active", type="boolean", nullable=false)
     */
    private $localActive = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="local", type="boolean", nullable=false)
     */
    private $local = false;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Location", mappedBy="currency")
     */
    private $location;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAlfa3(): ?string
    {
        return $this->alfa3;
    }

    public function setAlfa3(?string $alfa3): self
    {
        $this->alfa3 = $alfa3;

        return $this;
    }

    public function getSimbol(): ?string
    {
        return $this->simbol;
    }

    public function setSimbol(?string $simbol): self
    {
        $this->simbol = $simbol;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(?int $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getZeroDecimalBase(): ?int
    {
        return $this->zeroDecimalBase;
    }

    public function setZeroDecimalBase(?int $zeroDecimalBase): self
    {
        $this->zeroDecimalBase = $zeroDecimalBase;

        return $this;
    }

    public function getLocalActive(): ?bool
    {
        return $this->localActive;
    }

    public function setLocalActive(bool $localActive): self
    {
        $this->localActive = $localActive;

        return $this;
    }

    public function getLocal(): ?bool
    {
        return $this->local;
    }

    public function setLocal(bool $local): self
    {
        $this->local = $local;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
            $location->addCurrency($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->location->contains($location)) {
            $this->location->removeElement($location);
            $location->removeCurrency($this);
        }

        return $this;
    }

     /**
     * Consulta la moneda local activa de venezuela
     * @return CurrencyType
     */
    public static function getLocalActiveCurrency(){
        global  $kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $activeCurrency = $em->getRepository(CurrencyType::class)->findOneBy(['localActive' => true]);
        return $activeCurrency;
    }

    /**
     * Consulta la moneda local activa anterior de venezuela
     * @return CurrencyType
     */
    public static function getLocalPreviousCurrency(){
        global  $kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $previousCurrency = $em->getRepository(CurrencyType::class)->findOneBy(['id' => 148]);
        return $previousCurrency;
    }

    /**
     * Indica si una moneda en dolar
     * @param $alpha3
     * @return bool
     */

    public static function getExtraPreviousCurrency(){
        global  $kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $previousCurrency = $em->getRepository(CurrencyType::class)->findOneBy(['id' => 145]);
        return $previousCurrency;
    }


    /**
     * Indica si una moneda es la anterior activa en Venezuela
     * @param $alpha3
     * @return bool
     */
    public static function isLocalPreviousCurrency($alpha3) {
        $previousCurrency = self::getLocalPreviousCurrency();
        if ($alpha3 === $previousCurrency->getAlfa3())
            return true;

        return false;
    }

    /**
     * Indica si una moneda es la actual activa en venezuela
     * @param $alpha3
     * @return bool
     */
    public static function isLocalActiveCurrency($alpha3) {
        $activeCurrency = self::getLocalActiveCurrency();
        if ($alpha3 === $activeCurrency->getAlfa3())
            return true;

        return false;
    }

    /**
     * Obtiene las monedas locales de venezuela
     * @return mixed
     */
    public static function getLocalCurrencies(){
        global  $kernel;
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $activeCurrencies = $em->getRepository(CurrencyType::class)->findBy(['local' => true]);

        return $activeCurrencies;
    }

    /**
     * Indica si una moneda es de venezuela
     *
     * @param $alpha3
     * @return bool
     */
    public static function isLocalCurrency($alpha3) {
        $activeCurrencies = self::getLocalCurrencies();

        foreach ($activeCurrencies as $activeCurrency){
            if ($alpha3 === $activeCurrency->getAlfa3())
                return true;
        }
        return false;
    }

    /**
     * Devuelve la tasa de reconversión
     *     * 
     * @return float
     */
    public static function getRateReconversion() {
        return 100000;
    }
    /**
     * Convierte la cantidad a moneda local actual (Venezuela)
     *
     * @param $alfa3
     * @return bool
     */
    public static function showActiveCurrencyAmount($amount, $alfa3){
        if ((self::isLocalActiveCurrency($alfa3) || (! self::isLocalCurrency($alfa3)))){
            return $amount;
        }
        return round($amount/self::getRateReconversion(), 2);
    }

    /**
     * Convierte la cantidad a moneda local anterior (Venezuela)
     *
     * @param $alfa3
     * @return bool
     */
    public static function showPreviousCurrencyAmount($amount, $alfa3){
        if (self::isLocalPreviousCurrency($alfa3)) {
            return $amount;
        }
        return $amount*self::getRateReconversion();
    }

}
