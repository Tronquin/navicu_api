<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IpCollection
 *
 * @ORM\Table(name="ip_collection", indexes={@ORM\Index(name="idx_56d933665e9e89cb", columns={"location"})})
 * @ORM\Entity
 */
class IpCollection
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ip_collection_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="ip_start", type="float", precision=10, scale=0, nullable=false)
     */
    private $ipStart;

    /**
     * @var float
     *
     * @ORM\Column(name="ip_end", type="float", precision=10, scale=0, nullable=false)
     */
    private $ipEnd;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location", referencedColumnName="id")
     * })
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIpStart(): ?float
    {
        return $this->ipStart;
    }

    public function setIpStart(float $ipStart): self
    {
        $this->ipStart = $ipStart;

        return $this;
    }

    public function getIpEnd(): ?float
    {
        return $this->ipEnd;
    }

    public function setIpEnd(float $ipEnd): self
    {
        $this->ipEnd = $ipEnd;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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


}
