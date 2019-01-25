<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyPack
 *
 * @ORM\Table(name="daily_pack", indexes={@ORM\Index(name="IDX_D3D841B6A4834927", columns={"rule_room_id"}), @ORM\Index(name="IDX_D3D841B68BF6A167", columns={"daily_room_id"})})
 * @ORM\Entity
 */
class DailyPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="daily_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_completed", type="boolean", nullable=false)
     */
    private $isCompleted;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min_night", type="integer", nullable=true)
     */
    private $minNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_night", type="integer", nullable=true)
     */
    private $maxNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="specific_availability", type="integer", nullable=true)
     */
    private $specificAvailability;

    /**
     * @var float|null
     *
     * @ORM\Column(name="base_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $baseRate;

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
     * @var bool|null
     *
     * @ORM\Column(name="close_out", type="boolean", nullable=true)
     */
    private $closeOut;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="closed_to_arrival", type="boolean", nullable=true)
     */
    private $closedToArrival;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="closed_to_departure", type="boolean", nullable=true)
     */
    private $closedToDeparture;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_modified", type="datetime", nullable=true)
     */
    private $lastModified;

    /**
     * @var bool
     *
     * @ORM\Column(name="promotion", type="boolean", nullable=false)
     */
    private $promotion = false;

    /**
     * @var \RuleRoom
     *
     * @ORM\ManyToOne(targetEntity="RuleRoom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rule_room_id", referencedColumnName="id")
     * })
     */
    private $ruleRoom;

    /**
     * @var \DailyRoom
     *
     * @ORM\ManyToOne(targetEntity="DailyRoom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="daily_room_id", referencedColumnName="id")
     * })
     */
    private $dailyRoom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getMinNight(): ?int
    {
        return $this->minNight;
    }

    public function setMinNight(?int $minNight): self
    {
        $this->minNight = $minNight;

        return $this;
    }

    public function getMaxNight(): ?int
    {
        return $this->maxNight;
    }

    public function setMaxNight(?int $maxNight): self
    {
        $this->maxNight = $maxNight;

        return $this;
    }

    public function getSpecificAvailability(): ?int
    {
        return $this->specificAvailability;
    }

    public function setSpecificAvailability(?int $specificAvailability): self
    {
        $this->specificAvailability = $specificAvailability;

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

    public function getCloseOut(): ?bool
    {
        return $this->closeOut;
    }

    public function setCloseOut(?bool $closeOut): self
    {
        $this->closeOut = $closeOut;

        return $this;
    }

    public function getClosedToArrival(): ?bool
    {
        return $this->closedToArrival;
    }

    public function setClosedToArrival(?bool $closedToArrival): self
    {
        $this->closedToArrival = $closedToArrival;

        return $this;
    }

    public function getClosedToDeparture(): ?bool
    {
        return $this->closedToDeparture;
    }

    public function setClosedToDeparture(?bool $closedToDeparture): self
    {
        $this->closedToDeparture = $closedToDeparture;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(?\DateTimeInterface $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getPromotion(): ?bool
    {
        return $this->promotion;
    }

    public function setPromotion(bool $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getRuleRoom(): ?RuleRoom
    {
        return $this->ruleRoom;
    }

    public function setRuleRoom(?RuleRoom $ruleRoom): self
    {
        $this->ruleRoom = $ruleRoom;

        return $this;
    }

    public function getDailyRoom(): ?DailyRoom
    {
        return $this->dailyRoom;
    }

    public function setDailyRoom(?DailyRoom $dailyRoom): self
    {
        $this->dailyRoom = $dailyRoom;

        return $this;
    }


}
