<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyFavoriteImages
 *
 * @ORM\Table(name="property_favorite_images", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_db11d252ce933b9", columns={"image_document_id"})}, indexes={@ORM\Index(name="idx_db11d252549213ec", columns={"property_id"})})
 * @ORM\Entity
 */
class PropertyFavoriteImages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_favorite_images_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="order_gallery", type="integer", nullable=false)
     */
    private $orderGallery = '0';

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_document_id", referencedColumnName="id")
     * })
     */
    private $imageDocument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderGallery(): ?int
    {
        return $this->orderGallery;
    }

    public function setOrderGallery(int $orderGallery): self
    {
        $this->orderGallery = $orderGallery;

        return $this;
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

    public function getImageDocument(): ?Document
    {
        return $this->imageDocument;
    }

    public function setImageDocument(?Document $imageDocument): self
    {
        $this->imageDocument = $imageDocument;

        return $this;
    }


}
