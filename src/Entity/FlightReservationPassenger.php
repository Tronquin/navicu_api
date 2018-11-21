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
     * @ORM\Column(name="ticket", type="string", length=255, nullable=false)
     */
    private $ticket;

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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
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


}
