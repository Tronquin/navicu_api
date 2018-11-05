<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentInfoProperty
 *
 * @ORM\Table(name="payment_info_property", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_61c36e798bf21cde", columns={"property"}), @ORM\UniqueConstraint(name="uniq_61c36e79e447aca8", columns={"rif_id"})}, indexes={@ORM\Index(name="idx_61c36e7938248176", columns={"currency_id"}), @ORM\Index(name="idx_61c36e795e9e89cb", columns={"location"})})
 * @ORM\Entity
 */
class PaymentInfoProperty
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=3, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="payment_info_property_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="same_data_property", type="boolean", nullable=false)
     */
    private $sameDataProperty;

    /**
     * @var int
     *
     * @ORM\Column(name="charging_system", type="integer", nullable=false)
     */
    private $chargingSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_id", type="string", length=20, nullable=false)
     */
    private $taxId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="swift", type="string", length=14, nullable=true)
     */
    private $swift;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var array
     *
     * @ORM\Column(name="account", type="json_array", nullable=false)
     */
    private $account;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rif_id", referencedColumnName="id")
     * })
     */
    private $rif;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getSameDataProperty(): ?bool
    {
        return $this->sameDataProperty;
    }

    public function setSameDataProperty(bool $sameDataProperty): self
    {
        $this->sameDataProperty = $sameDataProperty;

        return $this;
    }

    public function getChargingSystem(): ?int
    {
        return $this->chargingSystem;
    }

    public function setChargingSystem(int $chargingSystem): self
    {
        $this->chargingSystem = $chargingSystem;

        return $this;
    }

    public function getTaxId(): ?string
    {
        return $this->taxId;
    }

    public function setTaxId(string $taxId): self
    {
        $this->taxId = $taxId;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getAccount()
    {
        return $this->account;
    }

    public function setAccount($account): self
    {
        $this->account = $account;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
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

    public function getRif(): ?Document
    {
        return $this->rif;
    }

    public function setRif(?Document $rif): self
    {
        $this->rif = $rif;

        return $this;
    }


}
