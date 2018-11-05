<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AavvTopDestination
 *
 * @ORM\Table(name="aavv_top_destination", indexes={@ORM\Index(name="idx_4ccc06f564d218e", columns={"location_id"}), @ORM\Index(name="idx_4ccc06f5d2c3b2dd", columns={"aavv_id"})})
 * @ORM\Entity
 */
class AavvTopDestination
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_top_destination_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number_visits", type="integer", nullable=true)
     */
    private $numberVisits;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \Aavv
     *
     * @ORM\ManyToOne(targetEntity="Aavv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_id", referencedColumnName="id")
     * })
     */
    private $aavv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberVisits(): ?int
    {
        return $this->numberVisits;
    }

    public function setNumberVisits(?int $numberVisits): self
    {
        $this->numberVisits = $numberVisits;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getAavv(): ?Aavv
    {
        return $this->aavv;
    }

    public function setAavv(?Aavv $aavv): self
    {
        $this->aavv = $aavv;

        return $this;
    }


}
