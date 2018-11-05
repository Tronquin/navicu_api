<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livingroom
 *
 * @ORM\Table(name="livingroom", indexes={@ORM\Index(name="idx_e6b761a654177093", columns={"room_id"})})
 * @ORM\Entity
 */
class Livingroom
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="livingroom_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amount_couch", type="integer", nullable=true)
     */
    private $amountCouch;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amount_people", type="integer", nullable=true)
     */
    private $amountPeople;

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

    public function getAmountCouch(): ?int
    {
        return $this->amountCouch;
    }

    public function setAmountCouch(?int $amountCouch): self
    {
        $this->amountCouch = $amountCouch;

        return $this;
    }

    public function getAmountPeople(): ?int
    {
        return $this->amountPeople;
    }

    public function setAmountPeople(?int $amountPeople): self
    {
        $this->amountPeople = $amountPeople;

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
