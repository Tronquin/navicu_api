<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirlineForeignBank
 *
 * @ORM\Table(name="airline_foreign_bank", indexes={@ORM\Index(name="idx_a7ecef99b8c9803", columns={"airline_bank_id"})})
 * @ORM\Entity
 */
class AirlineForeignBank
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airline_foreign_bank_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="account", type="string", length=255, nullable=true)
     */
    private $account;

    /**
     * @var string|null
     *
     * @ORM\Column(name="account_type", type="string", length=255, nullable=true)
     */
    private $accountType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="swift", type="string", length=255, nullable=true)
     */
    private $swift;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aba", type="string", length=255, nullable=true)
     */
    private $aba;

    /**
     * @var string|null
     *
     * @ORM\Column(name="beneficiary_name", type="string", length=255, nullable=true)
     */
    private $beneficiaryName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="beneficiary_address", type="string", length=255, nullable=true)
     */
    private $beneficiaryAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_platform", type="string", length=255, nullable=true)
     */
    private $paymentPlatform;

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_playform_email", type="string", length=255, nullable=true)
     */
    private $paymentPlayformEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bank_role", type="string", length=255, nullable=true)
     */
    private $bankRole;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var \AirlineBank
     *
     * @ORM\ManyToOne(targetEntity="AirlineBank")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_bank_id", referencedColumnName="id")
     * })
     */
    private $airlineBank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function setAccount(?string $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(?string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSwift(): ?string
    {
        return $this->swift;
    }

    public function setSwift(?string $swift): self
    {
        $this->swift = $swift;

        return $this;
    }

    public function getAba(): ?string
    {
        return $this->aba;
    }

    public function setAba(?string $aba): self
    {
        $this->aba = $aba;

        return $this;
    }

    public function getBeneficiaryName(): ?string
    {
        return $this->beneficiaryName;
    }

    public function setBeneficiaryName(?string $beneficiaryName): self
    {
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    public function getBeneficiaryAddress(): ?string
    {
        return $this->beneficiaryAddress;
    }

    public function setBeneficiaryAddress(?string $beneficiaryAddress): self
    {
        $this->beneficiaryAddress = $beneficiaryAddress;

        return $this;
    }

    public function getPaymentPlatform(): ?string
    {
        return $this->paymentPlatform;
    }

    public function setPaymentPlatform(?string $paymentPlatform): self
    {
        $this->paymentPlatform = $paymentPlatform;

        return $this;
    }

    public function getPaymentPlayformEmail(): ?string
    {
        return $this->paymentPlayformEmail;
    }

    public function setPaymentPlayformEmail(?string $paymentPlayformEmail): self
    {
        $this->paymentPlayformEmail = $paymentPlayformEmail;

        return $this;
    }

    public function getBankRole(): ?string
    {
        return $this->bankRole;
    }

    public function setBankRole(?string $bankRole): self
    {
        $this->bankRole = $bankRole;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAirlineBank(): ?AirlineBank
    {
        return $this->airlineBank;
    }

    public function setAirlineBank(?AirlineBank $airlineBank): self
    {
        $this->airlineBank = $airlineBank;

        return $this;
    }


}
