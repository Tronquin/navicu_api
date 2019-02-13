<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageTempRepository")
 */
class PackageTemp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $availability;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PackageTempPayment", mappedBy="package_temp_id")
     */
    private $packageTempPayments;

    public function __construct()
    {
        $this->packageTempPayments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * @return Collection|PackageTempPayment[]
     */
    public function getPackageTempPayments(): Collection
    {
        return $this->packageTempPayments;
    }

    public function addPackageTempPayment(PackageTempPayment $packageTempPayment): self
    {
        if (!$this->packageTempPayments->contains($packageTempPayment)) {
            $this->packageTempPayments[] = $packageTempPayment;
            $packageTempPayment->setPackageTempId($this);
        }

        return $this;
    }

    public function removePackageTempPayment(PackageTempPayment $packageTempPayment): self
    {
        if ($this->packageTempPayments->contains($packageTempPayment)) {
            $this->packageTempPayments->removeElement($packageTempPayment);
            // set the owning side to null (unless already changed)
            if ($packageTempPayment->getPackageTempId() === $this) {
                $packageTempPayment->setPackageTempId(null);
            }
        }

        return $this;
    }
}
