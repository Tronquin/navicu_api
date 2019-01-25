<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bed
 *
 * @ORM\Table(name="bed", indexes={@ORM\Index(name="idx_e647fcffbdb6797c", columns={"bedroom_id"})})
 * @ORM\Entity
 */
class Bed
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bed_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var \Bedroom
     *
     * @ORM\ManyToOne(targetEntity="Bedroom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bedroom_id", referencedColumnName="id")
     * })
     */
    private $bedroom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getBedroom(): ?Bedroom
    {
        return $this->bedroom;
    }

    public function setBedroom(?Bedroom $bedroom): self
    {
        $this->bedroom = $bedroom;

        return $this;
    }


}
