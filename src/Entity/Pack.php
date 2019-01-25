<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pack
 *
 * @ORM\Table(name="pack", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_97de5e23989d9b62", columns={"slug"})}, indexes={@ORM\Index(name="idx_97de5e2354177093", columns={"room_id"}), @ORM\Index(name="idx_97de5e23c54c8c93", columns={"type_id"})})
 * @ORM\Entity
 */
class Pack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

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
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="PropertyCancellationPolicy", mappedBy="pack")
     */
    private $propertycancellationpolicy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->propertycancellationpolicy = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getType(): ?Categories
    {
        return $this->type;
    }

    public function setType(?Categories $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|PropertyCancellationPolicy[]
     */
    public function getPropertycancellationpolicy(): Collection
    {
        return $this->propertycancellationpolicy;
    }

    public function addPropertycancellationpolicy(PropertyCancellationPolicy $propertycancellationpolicy): self
    {
        if (!$this->propertycancellationpolicy->contains($propertycancellationpolicy)) {
            $this->propertycancellationpolicy[] = $propertycancellationpolicy;
            $propertycancellationpolicy->addPack($this);
        }

        return $this;
    }

    public function removePropertycancellationpolicy(PropertyCancellationPolicy $propertycancellationpolicy): self
    {
        if ($this->propertycancellationpolicy->contains($propertycancellationpolicy)) {
            $this->propertycancellationpolicy->removeElement($propertycancellationpolicy);
            $propertycancellationpolicy->removePack($this);
        }

        return $this;
    }

}
