<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NvcBank
 *
 * @ORM\Table(name="nvc_bank", indexes={@ORM\Index(name="idx_e2fccd7938248176", columns={"currency_id"})})
 * @ORM\Entity
 */
class NvcBank
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="nvc_bank_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="account_number", type="string", length=255, nullable=false)
     */
    private $accountNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="billing_name", type="string", length=255, nullable=true)
     */
    private $billingName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="billing_email", type="string", length=255, nullable=true)
     */
    private $billingEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cable_code", type="string", length=255, nullable=true)
     */
    private $cableCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="swift_code", type="string", length=255, nullable=true)
     */
    private $swiftCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rif_code", type="string", length=255, nullable=true)
     */
    private $rifCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="routing_number", type="string", length=255, nullable=true)
     */
    private $routingNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="billing_address", type="string", length=350, nullable=true)
     */
    private $billingAddress;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

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

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getBillingName(): ?string
    {
        return $this->billingName;
    }

    public function setBillingName(?string $billingName): self
    {
        $this->billingName = $billingName;

        return $this;
    }

    public function getBillingEmail(): ?string
    {
        return $this->billingEmail;
    }

    public function setBillingEmail(?string $billingEmail): self
    {
        $this->billingEmail = $billingEmail;

        return $this;
    }

    public function getCableCode(): ?string
    {
        return $this->cableCode;
    }

    public function setCableCode(?string $cableCode): self
    {
        $this->cableCode = $cableCode;

        return $this;
    }

    public function getSwiftCode(): ?string
    {
        return $this->swiftCode;
    }

    public function setSwiftCode(?string $swiftCode): self
    {
        $this->swiftCode = $swiftCode;

        return $this;
    }

    public function getRifCode(): ?string
    {
        return $this->rifCode;
    }

    public function setRifCode(?string $rifCode): self
    {
        $this->rifCode = $rifCode;

        return $this;
    }

    public function getRoutingNumber(): ?string
    {
        return $this->routingNumber;
    }

    public function setRoutingNumber(?string $routingNumber): self
    {
        $this->routingNumber = $routingNumber;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getCurrency(): ?CurrencyType
    {
        return $this->currency;
    }

    public function setCurrency(?CurrencyType $currency): self
    {
        $this->currency = $currency;

        return $this;
    }


}
