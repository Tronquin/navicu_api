<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackageTempPaymentRepository")
 */
class PackageTempPayment
{
    /** Estatus de la reserva */
    const STATUS_PRE_RESERVATION = 0;
    const STATUS_IN_PROCESS = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_CANCEL = 3;

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

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
