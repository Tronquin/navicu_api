<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RateByKid
 *
 * @ORM\Table(name="rate_by_kid", indexes={@ORM\Index(name="idx_8bc7f2bd87414140", columns={"property_currency_id"}), @ORM\Index(name="idx_8bc7f2bd54177093", columns={"room_id"})})
 * @ORM\Entity
 */
class RateByKid
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="rate_by_kid_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="number_kid", type="integer", nullable=false)
     */
    private $numberKid;

    /**
     * @var int
     *
     * @ORM\Column(name="index", type="integer", nullable=false)
     */
    private $index = '0';

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

    public function getNumberKid(): ?int
    {
        return $this->numberKid;
    }

    public function setNumberKid(int $numberKid): self
    {
        $this->numberKid = $numberKid;

        return $this;
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function setIndex(int $index): self
    {
        $this->index = $index;

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
