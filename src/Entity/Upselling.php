<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Upselling
 *
 * @ORM\Table(name="upselling", indexes={@ORM\Index(name="IDX_3748C771549213EC", columns={"property_id"})})
 * @ORM\Entity
 */
class Upselling
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="upselling_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min", type="integer", nullable=true)
     */
    private $min;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max", type="integer", nullable=true)
     */
    private $max;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var int|null
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="img_route", type="string", length=255, nullable=true)
     */
    private $imgRoute;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="accumulated", type="boolean", nullable=true)
     */
    private $accumulated;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="prominent", type="boolean", nullable=true)
     */
    private $prominent;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UpsellingTag", mappedBy="upselling2")
     */
    private $upselling_tags;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Channel", inversedBy="yes")
     */
    private $channels;

    public function __construct()
    {
        $this->upselling_tags = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

    /**
     * @return Collection|UpsellingTag[]
     */
    public function getUpsellingTags(): Collection
    {
        return $this->upselling_tags;
    }

    public function addUpsellingTag(UpsellingTag $upsellingTag): self
    {
        if (!$this->upselling_tags->contains($upsellingTag)) {
            $this->upselling_tags[] = $upsellingTag;
            $upsellingTag->setUpselling2($this);
        }

        return $this;
    }

    public function removeUpsellingTag(UpsellingTag $upsellingTag): self
    {
        if ($this->upselling_tags->contains($upsellingTag)) {
            $this->upselling_tags->removeElement($upsellingTag);
            // set the owning side to null (unless already changed)
            if ($upsellingTag->getUpselling2() === $this) {
                $upsellingTag->setUpselling2(null);
            }
        }

        return $this;
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(?int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(?int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
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

    public function getImgRoute(): ?string
    {
        return $this->imgRoute;
    }

    public function setImgRoute(?string $imgRoute): self
    {
        $this->imgRoute = $imgRoute;

        return $this;
    }

    public function getAccumulated(): ?bool
    {
        return $this->accumulated;
    }

    public function setAccumulated(?bool $accumulated): self
    {
        $this->accumulated = $accumulated;

        return $this;
    }

    public function getProminent(): ?bool
    {
        return $this->prominent;
    }

    public function setProminent(?bool $prominent): self
    {
        $this->prominent = $prominent;

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

    /**
     * @return Collection|Channel[]
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->channels->contains($channel)) {
            $this->channels[] = $channel;
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->channels->contains($channel)) {
            $this->channels->removeElement($channel);
        }

        return $this;
    }


}
