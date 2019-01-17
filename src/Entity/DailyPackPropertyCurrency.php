<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyPackPropertyCurrency
 *
 * @ORM\Table(name="daily_pack_property_currency", indexes={@ORM\Index(name="idx_c4b2de2f87414140", columns={"property_currency_id"}), @ORM\Index(name="idx_c4b2de2fc6f863e3", columns={"daily_pack_id"})})
 * @ORM\Entity
 */
class DailyPackPropertyCurrency
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="daily_pack_property_currency_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float|null
     *
     * @ORM\Column(name="sell_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $sellRate;

    /**
     * @var float|null
     *
     * @ORM\Column(name="net_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $netRate;

    /**
     * @var float|null
     *
     * @ORM\Column(name="base_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $baseRate;

    /**
     * @var \PropertyCurrency
     *
     * @ORM\ManyToOne(targetEntity="PropertyCurrency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_currency_id", referencedColumnName="id")
     * })
     */
    private $propertyCurrency;

    /**
     * @var \DailyPack
     *
     * @ORM\ManyToOne(targetEntity="DailyPack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="daily_pack_id", referencedColumnName="id")
     * })
     */
    private $dailyPack;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSellRate(): ?float
    {
        return $this->sellRate;
    }

    public function setSellRate(?float $sellRate): self
    {
        $this->sellRate = $sellRate;

        return $this;
    }

    public function getNetRate(): ?float
    {
        return $this->netRate;
    }

    public function setNetRate(?float $netRate): self
    {
        $this->netRate = $netRate;

        return $this;
    }

    public function getBaseRate(): ?float
    {
        return $this->baseRate;
    }

    public function setBaseRate(?float $baseRate): self
    {
        $this->baseRate = $baseRate;

        return $this;
    }

    public function getPropertyCurrency(): ?PropertyCurrency
    {
        return $this->propertyCurrency;
    }

    public function setPropertyCurrency(?PropertyCurrency $propertyCurrency): self
    {
        $this->propertyCurrency = $propertyCurrency;

        return $this;
    }

    public function getDailyPack(): ?DailyPack
    {
        return $this->dailyPack;
    }

    public function setDailyPack(?DailyPack $dailyPack): self
    {
        $this->dailyPack = $dailyPack;

        return $this;
    }


}
