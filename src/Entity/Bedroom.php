<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bedroom
 *
 * @ORM\Table(name="bedroom", indexes={@ORM\Index(name="idx_e615435154177093", columns={"room_id"})})
 * @ORM\Entity
 */
class Bedroom
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bedroom_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="amount_people", type="integer", nullable=false)
     */
    private $amountPeople;

    /**
     * @var int
     *
     * @ORM\Column(name="bath", type="integer", nullable=false)
     */
    private $bath;

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

    public function getAmountPeople(): ?int
    {
        return $this->amountPeople;
    }

    public function setAmountPeople(int $amountPeople): self
    {
        $this->amountPeople = $amountPeople;

        return $this;
    }

    public function getBath(): ?int
    {
        return $this->bath;
    }

    public function setBath(int $bath): self
    {
        $this->bath = $bath;

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
