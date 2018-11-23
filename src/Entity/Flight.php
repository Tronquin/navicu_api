<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flight
 *
 * @ORM\Table(name="flight", indexes={@ORM\Index(name="idx_c257e60eec141ef8", columns={"airline"}), @ORM\Index(name="idx_c257e60ef73df7ae", columns={"flight_reservation_id"}), @ORM\Index(name="idx_c257e60eb91aa170", columns={"airport_from"}), @ORM\Index(name="idx_c257e60ed787d2c4", columns={"airport_to"}), @ORM\Index(name="idx_c257e60e6956883f", columns={"currency"}), @ORM\Index(name="IDX_C257E60E6B1C669", columns={"flight_lock"}), @ORM\Index(name="IDX_C257E60E46A06F05", columns={"flight_type_id"})})
 * @ORM\Entity
 */
class Flight
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_time", type="datetime", nullable=false)
     */
    private $departureTime;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=false)
     */
    private $duration;

    /**
     * @var bool
     *
     * @ORM\Column(name="return_flight", type="boolean", nullable=false)
     */
    private $returnFlight = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_time", type="datetime", nullable=false)
     */
    private $arrivalTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_rate", type="string", length=255, nullable=true)
     */
    private $typeRate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cabin", type="string", length=255, nullable=true)
     */
    private $cabin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="segment", type="integer", nullable=true)
     */
    private $segment;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airport_from", referencedColumnName="id")
     * })
     */
    private $airportFrom;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airport_to", referencedColumnName="id")
     * })
     */
    private $airportTo;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline", referencedColumnName="id")
     * })
     */
    private $airline;

    /**
     * @var \FlightLock
     *
     * @ORM\ManyToOne(targetEntity="FlightLock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_lock", referencedColumnName="id")
     * })
     */
    private $flightLock;

    /**
     * @var \FlightReservationGds
     *
     * @ORM\ManyToOne(targetEntity="FlightReservationGds", inversedBy="flights")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation_gds_id", referencedColumnName="id")
     * })
     */
    private $flightReservationGds;

    /**
     * @var \FlightType
     *
     * @ORM\ManyToOne(targetEntity="FlightType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_type_id", referencedColumnName="id")
     * })
     */
    private $flightType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeInterface $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getReturnFlight(): ?bool
    {
        return $this->returnFlight;
    }

    public function setReturnFlight(bool $returnFlight): self
    {
        $this->returnFlight = $returnFlight;

        return $this;
    }   

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(\DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getTypeRate(): ?string
    {
        return $this->typeRate;
    }

    public function setTypeRate(?string $typeRate): self
    {
        $this->typeRate = $typeRate;

        return $this;
    }

    public function getCabin(): ?string
    {
        return $this->cabin;
    }

    public function setCabin(?string $cabin): self
    {
        $this->cabin = $cabin;

        return $this;
    }

    public function getSegment(): ?int
    {
        return $this->segment;
    }

    public function setSegment(integer $segment): self
    {
        $this->segment = $segment;

        return $this;
    }

    public function getAirportFrom(): ?Airport
    {
        return $this->airportFrom;
    }

    public function setAirportFrom(?Airport $airportFrom): self
    {
        $this->airportFrom = $airportFrom;

        return $this;
    }

    public function getAirportTo(): ?Airport
    {
        return $this->airportTo;
    }

    public function setAirportTo(?Airport $airportTo): self
    {
        $this->airportTo = $airportTo;

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

    public function getFlightLock(): ?FlightLock
    {
        return $this->flightLock;
    }

    public function setFlightLock(?FlightLock $flightLock): self
    {
        $this->flightLock = $flightLock;

        return $this;
    }

    public function getFlightReservationGds(): ?FlightReservationGds
    {
        return $this->flightReservationGds;
    }

    public function setFlightReservation(?FlightReservationGds $flightReservation): self
    {
        $this->flightReservationGds = $flightReservation;

        return $this;
    }

    public function getFlightType(): ?FlightType
    {
        return $this->flightType;
    }

    public function setFlightType(?FlightType $flightType): self
    {
        $this->flightType = $flightType;

        return $this;
    }

    public function setFlightReservationGds(?FlightReservationGds $flightReservationGds): self
    {
        $this->flightReservationGds = $flightReservationGds;

        return $this;
    }
}
