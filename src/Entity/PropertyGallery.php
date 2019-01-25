<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyGallery
 *
 * @ORM\Table(name="property_gallery", indexes={@ORM\Index(name="idx_1ee632428bf21cde", columns={"property"}), @ORM\Index(name="idx_1ee63242c54c8c93", columns={"type_id"})})
 * @ORM\Entity
 */
class PropertyGallery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_gallery_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @var \ServiceType
     *
     * @ORM\ManyToOne(targetEntity="ServiceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getType(): ?ServiceType
    {
        return $this->type;
    }

    public function setType(?ServiceType $type): self
    {
        $this->type = $type;

        return $this;
    }


}
