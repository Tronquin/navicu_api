<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentType
 *
 * @ORM\Table(name="payment_type")
 * @ORM\Entity
 */
class PaymentType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="payment_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="commision", type="float", precision=10, scale=0, nullable=false)
     */
    private $commision = '0';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PaymentError", mappedBy="paymentType")
     */
    private $paymentErrors;

    public function __construct()
    {
        $this->paymentErrors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCommision(): ?float
    {
        return $this->commision;
    }

    public function setCommision(float $commision): self
    {
        $this->commision = $commision;

        return $this;
    }

    /**
     * @return Collection|PaymentError[]
     */
    public function getPaymentErrors(): Collection
    {
        return $this->paymentErrors;
    }

    public function addPaymentErrors(PaymentError $code): self
    {
        if (!$this->paymentErrors->contains($code)) {
            $this->paymentErrors[] = $code;
            $code->setPaymentType($this);
        }

        return $this;
    }

    public function removePaymentErrors(PaymentError $code): self
    {
        if ($this->paymentErrors->contains($code)) {
            $this->paymentErrors->removeElement($code);
            // set the owning side to null (unless already changed)
            if ($code->getPaymentType() === $this) {
                $code->setPaymentType(null);
            }
        }

        return $this;
    }


}
