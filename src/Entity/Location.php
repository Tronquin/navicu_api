<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location", indexes={@ORM\Index(name="idx_5e9e89cb2f7fde18", columns={"destination_type"}), @ORM\Index(name="idx_5e9e89cb79066886", columns={"root_id"}), @ORM\Index(name="idx_5e9e89cb727aca70", columns={"parent_id"}), @ORM\Index(name="idx_5e9e89cb2b099f37", columns={"location_type_id"}), @ORM\Index(name="idx_5e9e89cb8bac62af", columns={"city_id"})})
 * @ORM\Entity
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="location_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="city_id", type="integer", nullable=true)
     */
    private $cityId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var int|null
     *
     * @ORM\Column(name="lvl", type="integer", nullable=true)
     */
    private $lvl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alfa2", type="string", length=2, nullable=true)
     */
    private $alfa2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alfa3", type="string", length=3, nullable=true)
     */
    private $alfa3;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url_flag_icon", type="string", length=255, nullable=true)
     */
    private $urlFlagIcon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_prefix", type="string", length=3, nullable=true)
     */
    private $phonePrefix;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var int|null
     *
     * @ORM\Column(name="location_type_id", type="integer", nullable=true)
     */
    private $locationTypeId;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $visible = true;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destination_type", referencedColumnName="id")
     * })
     */
    private $destinationType;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="root_id", referencedColumnName="id")
     * })
     */
    private $root;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Language", inversedBy="location")
     * @ORM\JoinTable(name="location_language",
     *   joinColumns={
     *     @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     *   }
     * )
     */
    private $language;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CurrencyType", inversedBy="location")
     * @ORM\JoinTable(name="location_currency",
     *   joinColumns={
     *     @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     *   }
     * )
     */
    private $currency;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Location", inversedBy="location")
     * @ORM\JoinTable(name="dependency_location",
     *   joinColumns={
     *     @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="dependency_id", referencedColumnName="id")
     *   }
     * )
     */
    private $dependency;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->language = new \Doctrine\Common\Collections\ArrayCollection();
        $this->currency = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dependency = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityId(): ?int
    {
        return $this->cityId;
    }

    public function setCityId(?int $cityId): self
    {
        $this->cityId = $cityId;

        return $this;
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

    public function getAlfa2(): ?string
    {
        return $this->alfa2;
    }

    public function setAlfa2(?string $alfa2): self
    {
        $this->alfa2 = $alfa2;

        return $this;
    }

    public function getAlfa3(): ?string
    {
        return $this->alfa3;
    }

    public function setAlfa3(?string $alfa3): self
    {
        $this->alfa3 = $alfa3;

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

    public function getUrlFlagIcon(): ?string
    {
        return $this->urlFlagIcon;
    }

    public function setUrlFlagIcon(?string $urlFlagIcon): self
    {
        $this->urlFlagIcon = $urlFlagIcon;

        return $this;
    }

    public function getPhonePrefix(): ?string
    {
        return $this->phonePrefix;
    }

    public function setPhonePrefix(?string $phonePrefix): self
    {
        $this->phonePrefix = $phonePrefix;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLocationTypeId(): ?int
    {
        return $this->locationTypeId;
    }

    public function setLocationTypeId(?int $locationTypeId): self
    {
        $this->locationTypeId = $locationTypeId;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getDestinationType(): ?self
    {
        return $this->destinationType;
    }

    public function setDestinationType(?self $destinationType): self
    {
        $this->destinationType = $destinationType;

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

    /**
     * @return Collection|Language[]
     */
    public function getLanguage(): Collection
    {
        return $this->language;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->language->contains($language)) {
            $this->language[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->language->contains($language)) {
            $this->language->removeElement($language);
        }

        return $this;
    }

    /**
     * @return Collection|CurrencyType[]
     */
    public function getCurrency(): Collection
    {
        return $this->currency;
    }

    public function addCurrency(CurrencyType $currency): self
    {
        if (!$this->currency->contains($currency)) {
            $this->currency[] = $currency;
        }

        return $this;
    }

    public function removeCurrency(CurrencyType $currency): self
    {
        if ($this->currency->contains($currency)) {
            $this->currency->removeElement($currency);
        }

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getDependency(): Collection
    {
        return $this->dependency;
    }

    public function addDependency(Location $dependency): self
    {
        if (!$this->dependency->contains($dependency)) {
            $this->dependency[] = $dependency;
        }

        return $this;
    }

    public function removeDependency(Location $dependency): self
    {
        if ($this->dependency->contains($dependency)) {
            $this->dependency->removeElement($dependency);
        }

        return $this;
    }

}
