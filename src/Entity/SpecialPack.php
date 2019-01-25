<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialPack
 *
 * @ORM\Table(name="special_pack", indexes={@ORM\Index(name="IDX_15895F08549213EC", columns={"property_id"})})
 * @ORM\Entity
 */
class SpecialPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="special_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="banner_route", type="string", length=255, nullable=true)
     */
    private $bannerRoute;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min_night", type="integer", nullable=true)
     */
    private $minNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_night", type="integer", nullable=true)
     */
    private $maxNight;

    /**
     * @var string|null
     *
     * @ORM\Column(name="valid_days", type="text", nullable=true)
     */
    private $validDays;

    /**
     * @var float|null
     *
     * @ORM\Column(name="percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $percentage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getBannerRoute(): ?string
    {
        return $this->bannerRoute;
    }

    public function setBannerRoute(?string $bannerRoute): self
    {
        $this->bannerRoute = $bannerRoute;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMinNight(): ?int
    {
        return $this->minNight;
    }

    public function setMinNight(?int $minNight): self
    {
        $this->minNight = $minNight;

        return $this;
    }

    public function getMaxNight(): ?int
    {
        return $this->maxNight;
    }

    public function setMaxNight(?int $maxNight): self
    {
        $this->maxNight = $maxNight;

        return $this;
    }

    public function getValidDays(): ?string
    {
        return $this->validDays;
    }

    public function setValidDays(?string $validDays): self
    {
        $this->validDays = $validDays;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }


}
