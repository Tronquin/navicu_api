<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoomPackLinkage
 *
 * @ORM\Table(name="room_pack_linkage", indexes={@ORM\Index(name="idx_e7ee5f1d727aca70", columns={"parent_id"}), @ORM\Index(name="idx_e7ee5f1ddd62c21b", columns={"child_id"})})
 * @ORM\Entity
 */
class RoomPackLinkage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="room_pack_linkage_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_linked_availability", type="integer", nullable=true)
     */
    private $isLinkedAvailability;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_linked_max_night", type="integer", nullable=true)
     */
    private $isLinkedMaxNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_linked_min_night", type="integer", nullable=true)
     */
    private $isLinkedMinNight;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \Pack
     *
     * @ORM\ManyToOne(targetEntity="Pack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="child_id", referencedColumnName="id")
     * })
     */
    private $child;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getIsLinkedAvailability(): ?int
    {
        return $this->isLinkedAvailability;
    }

    public function setIsLinkedAvailability(?int $isLinkedAvailability): self
    {
        $this->isLinkedAvailability = $isLinkedAvailability;

        return $this;
    }

    public function getIsLinkedMaxNight(): ?int
    {
        return $this->isLinkedMaxNight;
    }

    public function setIsLinkedMaxNight(?int $isLinkedMaxNight): self
    {
        $this->isLinkedMaxNight = $isLinkedMaxNight;

        return $this;
    }

    public function getIsLinkedMinNight(): ?int
    {
        return $this->isLinkedMinNight;
    }

    public function setIsLinkedMinNight(?int $isLinkedMinNight): self
    {
        $this->isLinkedMinNight = $isLinkedMinNight;

        return $this;
    }

    public function getParent(): ?Room
    {
        return $this->parent;
    }

    public function setParent(?Room $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChild(): ?Pack
    {
        return $this->child;
    }

    public function setChild(?Pack $child): self
    {
        $this->child = $child;

        return $this;
    }


}
