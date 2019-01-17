<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoomSpecialPack
 *
 * @ORM\Table(name="room_special_pack", indexes={@ORM\Index(name="IDX_A3FB479BC115EE82", columns={"special_pack_id"}), @ORM\Index(name="IDX_A3FB479B54177093", columns={"room_id"})})
 * @ORM\Entity
 */
class RoomSpecialPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="room_special_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \SpecialPack
     *
     * @ORM\ManyToOne(targetEntity="SpecialPack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="special_pack_id", referencedColumnName="id")
     * })
     */
    private $specialPack;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialPack(): ?SpecialPack
    {
        return $this->specialPack;
    }

    public function setSpecialPack(?SpecialPack $specialPack): self
    {
        $this->specialPack = $specialPack;

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


}
