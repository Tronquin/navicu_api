<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AavvAdditionalQuota
 *
 * @ORM\Table(name="aavv_additional_quota")
 * @ORM\Entity
 */
class AavvAdditionalQuota
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_additional_quota_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aavv", inversedBy="additionalQuota")
     * @ORM\JoinTable(name="avvv_quota_monthly",
     *   joinColumns={
     *     @ORM\JoinColumn(name="additional_quota_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="aavv_id", referencedColumnName="id")
     *   }
     * )
     */
    private $aavv;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aavv = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection|Aavv[]
     */
    public function getAavv(): Collection
    {
        return $this->aavv;
    }

    public function addAavv(Aavv $aavv): self
    {
        if (!$this->aavv->contains($aavv)) {
            $this->aavv[] = $aavv;
        }

        return $this;
    }

    public function removeAavv(Aavv $aavv): self
    {
        if ($this->aavv->contains($aavv)) {
            $this->aavv->removeElement($aavv);
        }

        return $this;
    }

}
