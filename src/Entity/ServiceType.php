<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceType
 *
 * @ORM\Table(name="service_type", indexes={@ORM\Index(name="idx_429de3c579066886", columns={"root_id"}), @ORM\Index(name="idx_429de3c5727aca70", columns={"parent_id"})})
 * @ORM\Entity
 */
class ServiceType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="service_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lvl", type="integer", nullable=true)
     */
    private $lvl;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @var bool
     *
     * @ORM\Column(name="gallery", type="boolean", nullable=false)
     */
    private $gallery;

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
     * @var \ServiceType
     *
     * @ORM\ManyToOne(targetEntity="ServiceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \ServiceType
     *
     * @ORM\ManyToOne(targetEntity="ServiceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="root_id", referencedColumnName="id")
     * })
     */
    private $root;

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

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(?int $lvl): self
    {
        $this->lvl = $lvl;

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

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getGallery(): ?bool
    {
        return $this->gallery;
    }

    public function setGallery(bool $gallery): self
    {
        $this->gallery = $gallery;

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

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setRoot(?self $root): self
    {
        $this->root = $root;

        return $this;
    }


}
