<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RoomFeatureType
 *
 * @ORM\Table(name="room_feature_type", indexes={@ORM\Index(name="idx_6886c0c9727aca70", columns={"parent_id"})})
 * @ORM\Entity
 */
class RoomFeatureType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="room_feature_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="type_val", type="integer", nullable=false)
     */
    private $typeVal;

    /**
     * @var int|null
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    private $priority;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url_icon", type="string", length=255, nullable=true)
     */
    private $urlIcon;

    /**
     * @var \RoomFeatureType
     *
     * @ORM\ManyToOne(targetEntity="RoomFeatureType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="RoomType", inversedBy="roomfeaturetype")
     * @ORM\JoinTable(name="feature_type",
     *   joinColumns={
     *     @ORM\JoinColumn(name="roomfeaturetype_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="roomtype_id", referencedColumnName="id")
     *   }
     * )
     */
    private $roomtype;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roomtype = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeVal(): ?int
    {
        return $this->typeVal;
    }

    public function setTypeVal(int $typeVal): self
    {
        $this->typeVal = $typeVal;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getUrlIcon(): ?string
    {
        return $this->urlIcon;
    }

    public function setUrlIcon(?string $urlIcon): self
    {
        $this->urlIcon = $urlIcon;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|RoomType[]
     */
    public function getRoomtype(): Collection
    {
        return $this->roomtype;
    }

    public function addRoomtype(RoomType $roomtype): self
    {
        if (!$this->roomtype->contains($roomtype)) {
            $this->roomtype[] = $roomtype;
        }

        return $this;
    }

    public function removeRoomtype(RoomType $roomtype): self
    {
        if ($this->roomtype->contains($roomtype)) {
            $this->roomtype->removeElement($roomtype);
        }

        return $this;
    }

}
