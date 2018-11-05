<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocationMap
 *
 * @ORM\Table(name="location_map", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_f27f212e1b2bc117", columns={"coords_type_map"})})
 * @ORM\Entity
 */
class LocationMap
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="location_map_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="count_property", type="integer", nullable=false)
     */
    private $countProperty;

    /**
     * @var float
     *
     * @ORM\Column(name="min_sell_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $minSellRate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default"="1"})
     */
    private $status = '1';

    /**
     * @var \CoordsTypeMap
     *
     * @ORM\ManyToOne(targetEntity="CoordsTypeMap")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="coords_type_map", referencedColumnName="id")
     * })
     */
    private $coordsTypeMap;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCountProperty(): ?int
    {
        return $this->countProperty;
    }

    public function setCountProperty(int $countProperty): self
    {
        $this->countProperty = $countProperty;

        return $this;
    }

    public function getMinSellRate(): ?float
    {
        return $this->minSellRate;
    }

    public function setMinSellRate(float $minSellRate): self
    {
        $this->minSellRate = $minSellRate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCoordsTypeMap(): ?CoordsTypeMap
    {
        return $this->coordsTypeMap;
    }

    public function setCoordsTypeMap(?CoordsTypeMap $coordsTypeMap): self
    {
        $this->coordsTypeMap = $coordsTypeMap;

        return $this;
    }


}
