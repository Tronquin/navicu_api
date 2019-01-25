<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyCancellationPolicy
 *
 * @ORM\Table(name="property_cancellation_policy", indexes={@ORM\Index(name="idx_3cad9089549213ec", columns={"property_id"}), @ORM\Index(name="idx_3cad9089f0c13f52", columns={"cancellation_policy_id"})})
 * @ORM\Entity
 */
class PropertyCancellationPolicy
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_cancellation_policy_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \CancellationPolicy
     *
     * @ORM\ManyToOne(targetEntity="CancellationPolicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cancellation_policy_id", referencedColumnName="id")
     * })
     */
    private $cancellationPolicy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Pack", inversedBy="propertycancellationpolicy")
     * @ORM\JoinTable(name="pack_cancellation_policy",
     *   joinColumns={
     *     @ORM\JoinColumn(name="propertycancellationpolicy_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="pack_id", referencedColumnName="id")
     *   }
     * )
     */
    private $pack;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pack = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCancellationPolicy(): ?CancellationPolicy
    {
        return $this->cancellationPolicy;
    }

    public function setCancellationPolicy(?CancellationPolicy $cancellationPolicy): self
    {
        $this->cancellationPolicy = $cancellationPolicy;

        return $this;
    }

    /**
     * @return Collection|Pack[]
     */
    public function getPack(): Collection
    {
        return $this->pack;
    }

    public function addPack(Pack $pack): self
    {
        if (!$this->pack->contains($pack)) {
            $this->pack[] = $pack;
        }

        return $this;
    }

    public function removePack(Pack $pack): self
    {
        if ($this->pack->contains($pack)) {
            $this->pack->removeElement($pack);
        }

        return $this;
    }

}
