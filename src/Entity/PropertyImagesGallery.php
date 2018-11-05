<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyImagesGallery
 *
 * @ORM\Table(name="property_images_gallery", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_e92bd5cac5302bb", columns={"image_documet_id"})}, indexes={@ORM\Index(name="idx_e92bd5cb1468fbc", columns={"property_gallery_id"})})
 * @ORM\Entity
 */
class PropertyImagesGallery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_images_gallery_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="order_gallery", type="integer", nullable=false)
     */
    private $orderGallery = '0';

    /**
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_documet_id", referencedColumnName="id")
     * })
     */
    private $imageDocumet;

    /**
     * @var \PropertyGallery
     *
     * @ORM\ManyToOne(targetEntity="PropertyGallery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_gallery_id", referencedColumnName="id")
     * })
     */
    private $propertyGallery;

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

    public function getImageDocumet(): ?Document
    {
        return $this->imageDocumet;
    }

    public function setImageDocumet(?Document $imageDocumet): self
    {
        $this->imageDocumet = $imageDocumet;

        return $this;
    }

    public function getPropertyGallery(): ?PropertyGallery
    {
        return $this->propertyGallery;
    }

    public function setPropertyGallery(?PropertyGallery $propertyGallery): self
    {
        $this->propertyGallery = $propertyGallery;

        return $this;
    }


}
