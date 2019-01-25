<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordsTypeMap
 *
 * @ORM\Table(name="coords_type_map")
 * @ORM\Entity
 */
class CoordsTypeMap
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="coords_type_map_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="zoom", type="integer", nullable=false)
     */
    private $zoom;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=50, nullable=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=50, nullable=false)
     */
    private $latitude;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_location", type="boolean", nullable=false)
     */
    private $isLocation;

    /**
     * @var string
     *
     * @ORM\Column(name="perimeter", type="text", nullable=false)
     */
    private $perimeter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZoom(): ?int
    {
        return $this->zoom;
    }

    public function setZoom(int $zoom): self
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getIsLocation(): ?bool
    {
        return $this->isLocation;
    }

    public function setIsLocation(bool $isLocation): self
    {
        $this->isLocation = $isLocation;

        return $this;
    }

    public function getPerimeter(): ?string
    {
        return $this->perimeter;
    }

    public function setPerimeter(string $perimeter): self
    {
        $this->perimeter = $perimeter;

        return $this;
    }


}
