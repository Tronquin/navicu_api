<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirlineFlightTypeRate
 *
 * @ORM\Table(name="airline_flight_type_rate", indexes={@ORM\Index(name="idx_aaf21bcd6956883f", columns={"currency"}), @ORM\Index(name="idx_aaf21bcdec141ef8", columns={"airline"}), @ORM\Index(name="idx_aaf21bcd16fbe783", columns={"flight_type_rate"})})
 * @ORM\Entity
 */
class AirlineFlightTypeRate
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airline_flight_type_rate_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="increment_type", type="integer", nullable=false)
     */
    private $incrementType;

    /**
     * @var float
     *
     * @ORM\Column(name="increment_value", type="float", precision=10, scale=0, nullable=false)
     */
    private $incrementValue;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="eliminated_at", type="datetime", nullable=true)
     */
    private $eliminatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="inactive", type="boolean", nullable=false)
     */
    private $inactive = false;

    /**
     * @var \FlightTypeRate
     *
     * @ORM\ManyToOne(targetEntity="FlightTypeRate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_type_rate", referencedColumnName="id")
     * })
     */
    private $flightTypeRate;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline", referencedColumnName="id")
     * })
     */
    private $airline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIncrementType(): ?int
    {
        return $this->incrementType;
    }

    public function setIncrementType(int $incrementType): self
    {
        $this->incrementType = $incrementType;

        return $this;
    }

    public function getIncrementValue(): ?float
    {
        return $this->incrementValue;
    }

    public function setIncrementValue(float $incrementValue): self
    {
        $this->incrementValue = $incrementValue;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEliminatedAt(): ?\DateTimeInterface
    {
        return $this->eliminatedAt;
    }

    public function setEliminatedAt(?\DateTimeInterface $eliminatedAt): self
    {
        $this->eliminatedAt = $eliminatedAt;

        return $this;
    }

    public function getInactive(): ?bool
    {
        return $this->inactive;
    }

    public function setInactive(bool $inactive): self
    {
        $this->inactive = $inactive;

        return $this;
    }

    public function getFlightTypeRate(): ?FlightTypeRate
    {
        return $this->flightTypeRate;
    }

    public function setFlightTypeRate(?FlightTypeRate $flightTypeRate): self
    {
        $this->flightTypeRate = $flightTypeRate;

        return $this;
    }

    public function getCurrency(): ?CurrencyType
    {
        return $this->currency;
    }

    public function setCurrency(?CurrencyType $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAirline(): ?Airline
    {
        return $this->airline;
    }

    public function setAirline(?Airline $airline): self
    {
        $this->airline = $airline;

        return $this;
    }


}
