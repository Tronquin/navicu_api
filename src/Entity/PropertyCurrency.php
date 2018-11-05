<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyCurrency
 *
 * @ORM\Table(name="property_currency", indexes={@ORM\Index(name="idx_37d1bc7b549213ec", columns={"property_id"}), @ORM\Index(name="idx_37d1bc7b16fe72e1", columns={"updated_by"}), @ORM\Index(name="idx_37d1bc7bde12ab56", columns={"created_by"}), @ORM\Index(name="idx_37d1bc7b38248176", columns={"currency_id"})})
 * @ORM\Entity
 */
class PropertyCurrency
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_currency_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="tax", type="boolean", nullable=true)
     */
    private $tax;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tax_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $taxRate;

    /**
     * @var int
     *
     * @ORM\Column(name="rate_type", type="integer", nullable=false, options={"default"="2"})
     */
    private $rateType = '2';

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
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * })
     */
    private $createdBy;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     * })
     */
    private $updatedBy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTax(): ?bool
    {
        return $this->tax;
    }

    public function setTax(?bool $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    public function setTaxRate(?float $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getRateType(): ?int
    {
        return $this->rateType;
    }

    public function setRateType(int $rateType): self
    {
        $this->rateType = $rateType;

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

    public function getCurrency(): ?CurrencyType
    {
        return $this->currency;
    }

    public function setCurrency(?CurrencyType $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCreatedBy(): ?NvcProfile
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?NvcProfile $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?NvcProfile
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?NvcProfile $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }


}
