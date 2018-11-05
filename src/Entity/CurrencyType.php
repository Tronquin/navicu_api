<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyType
 *
 * @ORM\Table(name="currency_type")
 * @ORM\Entity
 */
class CurrencyType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="currency_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="alfa3", type="string", length=3, nullable=true)
     */
    private $alfa3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="simbol", type="string", length=255, nullable=true)
     */
    private $simbol;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var int|null
     *
     * @ORM\Column(name="round", type="integer", nullable=true)
     */
    private $round;

    /**
     * @var int|null
     *
     * @ORM\Column(name="zero_decimal_base", type="integer", nullable=true, options={"default"="100"})
     */
    private $zeroDecimalBase = '100';

    /**
     * @var bool
     *
     * @ORM\Column(name="local_active", type="boolean", nullable=false)
     */
    private $localActive = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="local", type="boolean", nullable=false)
     */
    private $local = false;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Location", mappedBy="currency")
     */
    private $location;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getAlfa3(): ?string
    {
        return $this->alfa3;
    }

    public function setAlfa3(?string $alfa3): self
    {
        $this->alfa3 = $alfa3;

        return $this;
    }

    public function getSimbol(): ?string
    {
        return $this->simbol;
    }

    public function setSimbol(?string $simbol): self
    {
        $this->simbol = $simbol;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(?int $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getZeroDecimalBase(): ?int
    {
        return $this->zeroDecimalBase;
    }

    public function setZeroDecimalBase(?int $zeroDecimalBase): self
    {
        $this->zeroDecimalBase = $zeroDecimalBase;

        return $this;
    }

    public function getLocalActive(): ?bool
    {
        return $this->localActive;
    }

    public function setLocalActive(bool $localActive): self
    {
        $this->localActive = $localActive;

        return $this;
    }

    public function getLocal(): ?bool
    {
        return $this->local;
    }

    public function setLocal(bool $local): self
    {
        $this->local = $local;

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
            $location->addCurrency($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->location->contains($location)) {
            $this->location->removeElement($location);
            $location->removeCurrency($this);
        }

        return $this;
    }

}
