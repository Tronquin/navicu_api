<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightFareFamily
 *
 * @ORM\Table(name="flight_fare_family", indexes={@ORM\Index(name="IDX_DFD160088C3B68A4", columns={"flight_reservation_gds_id"})})
 * @ORM\Entity
 */
class FlightFareFamily
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_fare_family_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="itinerary", type="text", nullable=true)
     */
    private $itinerary;

    /**
     * @var string|null
     *
     * @ORM\Column(name="services", type="text", nullable=true)
     */
    private $services;

    /**
     * @var string|null
     *
     * @ORM\Column(name="search_options", type="text", nullable=true)
     */
    private $searchOptions;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prices", type="text", nullable=true)
     */
    private $prices;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="selected", type="boolean", nullable=true)
     */
    private $selected;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getItinerary(): ?string
    {
        return $this->itinerary;
    }

    public function setItinerary(?string $itinerary): self
    {
        $this->itinerary = $itinerary;

        return $this;
    }

    public function getServices(): ?string
    {
        return $this->services;
    }

    public function setServices(?string $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function getSearchOptions(): ?string
    {
        return $this->searchOptions;
    }

    public function setSearchOptions(?string $searchOptions): self
    {
        $this->searchOptions = $searchOptions;

        return $this;
    }

    public function getPrices(): ?string
    {
        return $this->prices;
    }

    public function setPrices(?string $prices): self
    {
        $this->prices = $prices;

        return $this;
    }

    public function getSelected(): ?bool
    {
        return $this->selected;
    }

    public function setSelected(?bool $selected): self
    {
        $this->selected = $selected;

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

    public function getFlightReservationGds(): ?FlightReservationGds
    {
        return $this->flightReservationGds;
    }

    public function setFlightReservationGds(?FlightReservationGds $flightReservationGds): self
    {
        $this->flightReservationGds = $flightReservationGds;

        return $this;
    }


}
