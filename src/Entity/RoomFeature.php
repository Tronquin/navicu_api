<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoomFeature
 *
 * @ORM\Table(name="room_feature", indexes={@ORM\Index(name="idx_f3f5c98654177093", columns={"room_id"}), @ORM\Index(name="idx_f3f5c98660e4b879", columns={"feature_id"})})
 * @ORM\Entity
 */
class RoomFeature
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="room_feature_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

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
     * @var \RoomFeatureType
     *
     * @ORM\ManyToOne(targetEntity="RoomFeatureType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="feature_id", referencedColumnName="id")
     * })
     */
    private $feature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

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

    public function getFeature(): ?RoomFeatureType
    {
        return $this->feature;
    }

    public function setFeature(?RoomFeatureType $feature): self
    {
        $this->feature = $feature;

        return $this;
    }


}
