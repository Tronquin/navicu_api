<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoomImagesGallery
 *
 * @ORM\Table(name="room_images_gallery", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_915691a5ce933b9", columns={"image_document_id"})}, indexes={@ORM\Index(name="idx_915691a554177093", columns={"room_id"})})
 * @ORM\Entity
 */
class RoomImagesGallery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="room_images_gallery_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="order_gallery", type="integer", nullable=false)
     */
    private $orderGallery = '0';

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

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

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

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
