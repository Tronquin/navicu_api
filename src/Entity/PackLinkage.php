<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PackLinkage
 *
 * @ORM\Table(name="pack_linkage", indexes={@ORM\Index(name="idx_519c478e54177093", columns={"room_id"}), @ORM\Index(name="idx_519c478e727aca70", columns={"parent_id"}), @ORM\Index(name="idx_519c478edd62c21b", columns={"child_id"})})
 * @ORM\Entity
 */
class PackLinkage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pack_linkage_id_seq", allocationSize=1, initialValue=1)
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
     * @var int
     *
     * @ORM\Column(name="variation_type_pack", type="integer", nullable=false)
     */
    private $variationTypePack;

    /**
     * @var float|null
     *
     * @ORM\Column(name="is_linked_sell_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $isLinkedSellRate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="is_linked_availability", type="integer", nullable=true)
     */
    private $isLinkedAvailability;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_linked_close_out", type="boolean", nullable=false)
     */
    private $isLinkedCloseOut;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_linked_cta", type="boolean", nullable=false)
     */
    private $isLinkedCta;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_linked_ctd", type="boolean", nullable=false)
     */
    private $isLinkedCtd;

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
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var \Pack
     *
     * @ORM\ManyToOne(targetEntity="Pack")
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

    public function getVariationTypePack(): ?int
    {
        return $this->variationTypePack;
    }

    public function setVariationTypePack(int $variationTypePack): self
    {
        $this->variationTypePack = $variationTypePack;

        return $this;
    }

    public function getIsLinkedSellRate(): ?float
    {
        return $this->isLinkedSellRate;
    }

    public function setIsLinkedSellRate(?float $isLinkedSellRate): self
    {
        $this->isLinkedSellRate = $isLinkedSellRate;

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

    public function getIsLinkedCloseOut(): ?bool
    {
        return $this->isLinkedCloseOut;
    }

    public function setIsLinkedCloseOut(bool $isLinkedCloseOut): self
    {
        $this->isLinkedCloseOut = $isLinkedCloseOut;

        return $this;
    }

    public function getIsLinkedCta(): ?bool
    {
        return $this->isLinkedCta;
    }

    public function setIsLinkedCta(bool $isLinkedCta): self
    {
        $this->isLinkedCta = $isLinkedCta;

        return $this;
    }

    public function getIsLinkedCtd(): ?bool
    {
        return $this->isLinkedCtd;
    }

    public function setIsLinkedCtd(bool $isLinkedCtd): self
    {
        $this->isLinkedCtd = $isLinkedCtd;

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

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getParent(): ?Pack
    {
        return $this->parent;
    }

    public function setParent(?Pack $parent): self
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
