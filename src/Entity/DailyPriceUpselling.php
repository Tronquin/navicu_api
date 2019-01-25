<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyPriceUpselling
 *
 * @ORM\Table(name="daily_price_upselling", indexes={@ORM\Index(name="IDX_14D1C66318E5767C", columns={"currency_type_id"})})
 * @ORM\Entity
 */
class DailyPriceUpselling
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="daily_price_upselling_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="daily_upselling_id", type="integer", nullable=true)
     */
    private $dailyUpsellingId;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_type_id", referencedColumnName="id")
     * })
     */
    private $currencyType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDailyUpsellingId(): ?int
    {
        return $this->dailyUpsellingId;
    }

    public function setDailyUpsellingId(?int $dailyUpsellingId): self
    {
        $this->dailyUpsellingId = $dailyUpsellingId;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrencyType(): ?CurrencyType
    {
        return $this->currencyType;
    }

    public function setCurrencyType(?CurrencyType $currencyType): self
    {
        $this->currencyType = $currencyType;

        return $this;
    }


}
