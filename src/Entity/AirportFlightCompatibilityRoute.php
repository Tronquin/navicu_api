<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirportFlightCompatibilityRoute
 *
 * @ORM\Table(name="airport_flight_compatibility_route", indexes={@ORM\Index(name="idx_89104cc17522fbab", columns={"destiny"}), @ORM\Index(name="idx_89104cc1def1561e", columns={"origin"})})
 * @ORM\Entity
 */
class AirportFlightCompatibilityRoute
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airport_flight_compatibility_route_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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

    public function getId(): ?int
    {
        return $this->id;
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


}
