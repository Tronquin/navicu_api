<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightReservationPassenger
 *
 * @ORM\Table(name="flight_reservation_passenger", indexes={@ORM\Index(name="IDX_8C649F0A4502E565", columns={"passenger_id"}), @ORM\Index(name="IDX_8C649F0A8C3B68A4", columns={"flight_reservation_gds_id"})})
 * @ORM\Entity
 */
class FlightReservationPassenger
{
    const STATUS_WITHOUT_TICKET = 0;
    const STATUS_WITH_TICKET = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_reservation_passenger_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket", type="string", length=255, nullable=true)
     */
    private $ticket;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="commision", type="float", precision=10, scale=0, nullable=true)
     */
    private $commision;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

     /**
     * @var \Passenger
     *
     * @ORM\ManyToOne(targetEntity="Passenger", inversedBy="tickets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="passenger_id", referencedColumnName="id")
     * })
     */
    private $passenger;

     /**
     * @var \FlightReservationGds
     *
     * @ORM\ManyToOne(targetEntity="FlightReservationGds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation_gds_id", referencedColumnName="id")
     * })
     */
    private $flightReservationGds;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    public function setTicket(string $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCommision(): ?float
    {
        return $this->commision;
    }

    public function setCommision(float $commision): self
    {
        $this->commision = $commision;

        return $this;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPassenger(): ?Passenger
    {
        return $this->passenger;
    }

    public function setPassenger(?Passenger $passenger): self
    {
        $this->passenger = $passenger;

        return $this;
    }

    public function getFlightReservationGds(): ?FlightReservationGds
    {
        return $this->flightReservationGds;
    }

    public function setFlightReservationGds(?FlightReservationGds $flightReservationGds): self
    {
        $this->flightReservationGds = $flightReservationGds;

        return $this;
    }

    public function hasTicket()
    {
        return $this->status === self::STATUS_WITH_TICKET && ! is_null($this->ticket);
    }
}
