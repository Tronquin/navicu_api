<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightSeatReservation
 *
 * @ORM\Table(name="flight_seat_reservation", indexes={@ORM\Index(name="IDX_8F67417C4502E565", columns={"passenger_id"}), @ORM\Index(name="IDX_8F67417C91F478C5", columns={"flight_id"})})
 * @ORM\Entity
 */
class FlightSeatReservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_seat_reservation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="seat", type="string", length=15, nullable=false)
     */
    private $seat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Passenger
     *
     * @ORM\ManyToOne(targetEntity="Passenger")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="passenger_id", referencedColumnName="id")
     * })
     */
    private $passenger;

    /**
     * @var \Flight
     *
     * @ORM\ManyToOne(targetEntity="Flight")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_id", referencedColumnName="id")
     * })
     */
    private $flight;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeat(): ?string
    {
        return $this->seat;
    }

    public function setSeat(string $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }


}
