<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageTempPaymentRepository")
 */
class PackageTempPayment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PackageTemp", inversedBy="packageTempPayments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $package_temp;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPackageTemp(): ?PackageTemp
    {
        return $this->package_temp;
    }

    public function setPackageTemp(?PackageTemp $package_temp): self
    {
        $this->package_temp = $package_temp;

        return $this;
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
}
