<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightLock
 *
 * @ORM\Table(name="flight_lock", indexes={@ORM\Index(name="idx_6b1c6697522fbab", columns={"destiny"}), @ORM\Index(name="idx_6b1c669aaf21bcd", columns={"airline_flight_type_rate"}), @ORM\Index(name="idx_6b1c669def1561e", columns={"origin"}), @ORM\Index(name="IDX_6B1C66916FE72E1", columns={"updated_by"}), @ORM\Index(name="IDX_6B1C669DE12AB56", columns={"created_by"})})
 * @ORM\Entity(repositoryClass="App\Repository\FlightLockRepository"))
 */
class FlightLock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_lock_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="trips", type="integer", nullable=false)
     */
    private $trips;

    /**
     * @var string
     *
     * @ORM\Column(name="increment_description", type="string", length=255, nullable=false)
     */
    private $incrementDescription;

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
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @var float|null
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var float|null
     *
     * @ORM\Column(name="backup_amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $backupAmount;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     * })
     */
    private $updatedBy;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destiny", referencedColumnName="id")
     * })
     */
    private $destiny;

    /**
     * @var \AirlineFlightTypeRate
     *
     * @ORM\ManyToOne(targetEntity="AirlineFlightTypeRate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_flight_type_rate", referencedColumnName="id")
     * })
     */
    private $airlineFlightTypeRate;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * })
     */
    private $createdBy;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="origin", referencedColumnName="id")
     * })
     */
    private $origin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrips(): ?int
    {
        return $this->trips;
    }

    public function setTrips(int $trips): self
    {
        $this->trips = $trips;

        return $this;
    }

    public function getIncrementDescription(): ?string
    {
        return $this->incrementDescription;
    }

    public function setIncrementDescription(string $incrementDescription): self
    {
        $this->incrementDescription = $incrementDescription;

        return $this;
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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getBackupAmount(): ?float
    {
        return $this->backupAmount;
    }

    public function setBackupAmount(?float $backupAmount): self
    {
        $this->backupAmount = $backupAmount;

        return $this;
    }

    public function getUpdatedBy(): ?NvcProfile
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?NvcProfile $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getDestiny(): ?Airport
    {
        return $this->destiny;
    }

    public function setDestiny(?Airport $destiny): self
    {
        $this->destiny = $destiny;

        return $this;
    }

    public function getAirlineFlightTypeRate(): ?AirlineFlightTypeRate
    {
        return $this->airlineFlightTypeRate;
    }

    public function setAirlineFlightTypeRate(?AirlineFlightTypeRate $airlineFlightTypeRate): self
    {
        $this->airlineFlightTypeRate = $airlineFlightTypeRate;

        return $this;
    }

    public function getCreatedBy(): ?NvcProfile
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?NvcProfile $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getOrigin(): ?Airport
    {
        return $this->origin;
    }

    public function setOrigin(?Airport $origin): self
    {
        $this->origin = $origin;

        return $this;
    }


}
