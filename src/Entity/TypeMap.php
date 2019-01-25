<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeMap
 *
 * @ORM\Table(name="type_map", indexes={@ORM\Index(name="idx_91ba4c5af27f212e", columns={"location_map"})})
 * @ORM\Entity
 */
class TypeMap
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="type_map_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer", nullable=false)
     */
    private $count;

    /**
     * @var \LocationMap
     *
     * @ORM\ManyToOne(targetEntity="LocationMap")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_map", referencedColumnName="id")
     * })
     */
    private $locationMap;

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

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getLocationMap(): ?LocationMap
    {
        return $this->locationMap;
    }

    public function setLocationMap(?LocationMap $locationMap): self
    {
        $this->locationMap = $locationMap;

        return $this;
    }


}
