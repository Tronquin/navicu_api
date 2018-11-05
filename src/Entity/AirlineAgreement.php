<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirlineAgreement
 *
 * @ORM\Table(name="airline_agreement", indexes={@ORM\Index(name="idx_38915d05def1561e", columns={"origin"}), @ORM\Index(name="idx_38915d053929001b", columns={"airline_return"}), @ORM\Index(name="idx_38915d057522fbab", columns={"destiny"}), @ORM\Index(name="idx_38915d05dfec3f39", columns={"rate"}), @ORM\Index(name="idx_38915d05e15e478", columns={"airline_one_way"})})
 * @ORM\Entity
 */
class AirlineAgreement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airline_agreement_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_return", referencedColumnName="id")
     * })
     */
    private $airlineReturn;

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
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="origin", referencedColumnName="id")
     * })
     */
    private $origin;

    /**
     * @var \FlightTypeRate
     *
     * @ORM\ManyToOne(targetEntity="FlightTypeRate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rate", referencedColumnName="id")
     * })
     */
    private $rate;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_one_way", referencedColumnName="id")
     * })
     */
    private $airlineOneWay;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirlineReturn(): ?Airline
    {
        return $this->airlineReturn;
    }

    public function setAirlineReturn(?Airline $airlineReturn): self
    {
        $this->airlineReturn = $airlineReturn;

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

    public function getOrigin(): ?Airport
    {
        return $this->origin;
    }

    public function setOrigin(?Airport $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getRate(): ?FlightTypeRate
    {
        return $this->rate;
    }

    public function setRate(?FlightTypeRate $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getAirlineOneWay(): ?Airline
    {
        return $this->airlineOneWay;
    }

    public function setAirlineOneWay(?Airline $airlineOneWay): self
    {
        $this->airlineOneWay = $airlineOneWay;

        return $this;
    }


}
