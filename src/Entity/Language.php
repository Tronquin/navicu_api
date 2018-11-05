<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity
 */
class Language
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=3, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="language_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="native", type="string", length=255, nullable=false)
     */
    private $native;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Location", mappedBy="language")
     */
    private $location;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Property", mappedBy="language")
     */
    private $property;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
        $this->property = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNative(): ?string
    {
        return $this->native;
    }

    public function setNative(string $native): self
    {
        $this->native = $native;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
            $location->addLanguage($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->location->contains($location)) {
            $this->location->removeElement($location);
            $location->removeLanguage($this);
        }

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
            $property->addLanguage($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->property->contains($property)) {
            $this->property->removeElement($property);
            $property->removeLanguage($this);
        }

        return $this;
    }

}
