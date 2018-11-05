<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightTicket
 *
 * @ORM\Table(name="flight_ticket", indexes={@ORM\Index(name="idx_a8c6fcb4f73df7ae", columns={"flight_reservation"}), @ORM\Index(name="idx_a8c6fcb4c257e60e", columns={"flight"})})
 * @ORM\Entity
 */
class FlightTicket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_ticket_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=false)
     */
    private $number;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="commision", type="float", precision=10, scale=0, nullable=false)
     */
    private $commision;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var int
     *
     * @ORM\Column(name="way", type="integer", nullable=false, options={"default"="1"})
     */
    private $way = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \Flight
     *
     * @ORM\ManyToOne(targetEntity="Flight")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight", referencedColumnName="id")
     * })
     */
    private $flight;

    /**
     * @var \FlightReservation
     *
     * @ORM\ManyToOne(targetEntity="FlightReservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation", referencedColumnName="id")
     * })
     */
    private $flightReservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getWay(): ?int
    {
        return $this->way;
    }

    public function setWay(int $way): self
    {
        $this->way = $way;

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

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getFlightReservation(): ?FlightReservation
    {
        return $this->flightReservation;
    }

    public function setFlightReservation(?FlightReservation $flightReservation): self
    {
        $this->flightReservation = $flightReservation;

        return $this;
    }


}
