<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChildrenAge
 *
 * @ORM\Table(name="children_age", indexes={@ORM\Index(name="idx_c5d9bc327e8c0992", columns={"reservation_pack_id"})})
 * @ORM\Entity
 */
class ChildrenAge
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="children_age_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var \ReservationPack
     *
     * @ORM\ManyToOne(targetEntity="ReservationPack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_pack_id", referencedColumnName="id")
     * })
     */
    private $reservationPack;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getReservationPack(): ?ReservationPack
    {
        return $this->reservationPack;
    }

    public function setReservationPack(?ReservationPack $reservationPack): self
    {
        $this->reservationPack = $reservationPack;

        return $this;
    }


}
