<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightLockInventoryTransactions
 *
 * @ORM\Table(name="flight_lock_inventory_transactions", indexes={@ORM\Index(name="idx_d7e7d60f6b1c669", columns={"flight_lock"})})
 * @ORM\Entity
 */
class FlightLockInventoryTransactions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_lock_inventory_transactions_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @var \FlightLock
     *
     * @ORM\ManyToOne(targetEntity="FlightLock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_lock", referencedColumnName="id")
     * })
     */
    private $flightLock;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getFlightLock(): ?FlightLock
    {
        return $this->flightLock;
    }

    public function setFlightLock(?FlightLock $flightLock): self
    {
        $this->flightLock = $flightLock;

        return $this;
    }


}
