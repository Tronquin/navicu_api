<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RateByPeople
 *
 * @ORM\Table(name="rate_by_people", indexes={@ORM\Index(name="idx_cacc218287414140", columns={"property_currency_id"}), @ORM\Index(name="idx_cacc218254177093", columns={"room_id"})})
 * @ORM\Entity
 */
class RateByPeople
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="rate_by_people_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $amountRate;

    /**
     * @var int
     *
     * @ORM\Column(name="number_people", type="integer", nullable=false)
     */
    private $numberPeople;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var \PropertyCurrency
     *
     * @ORM\ManyToOne(targetEntity="PropertyCurrency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_currency_id", referencedColumnName="id")
     * })
     */
    private $propertyCurrency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmountRate(): ?float
    {
        return $this->amountRate;
    }

    public function setAmountRate(float $amountRate): self
    {
        $this->amountRate = $amountRate;

        return $this;
    }

    public function getNumberPeople(): ?int
    {
        return $this->numberPeople;
    }

    public function setNumberPeople(int $numberPeople): self
    {
        $this->numberPeople = $numberPeople;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

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


}
