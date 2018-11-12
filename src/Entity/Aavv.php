<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aavv
 *
 * @ORM\Table(name="aavv", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_2bc8e4148530a5dc", columns={"subdomain_id"}), @ORM\UniqueConstraint(name="uniq_2bc8e414f98f144a", columns={"logo_id"})})
 * @ORM\Entity
 */
class Aavv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rif", type="string", length=255, nullable=true)
     */
    private $rif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=true)
     */
    private $publicId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="company_email", type="string", length=255, nullable=true)
     */
    private $companyEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="social_reason", type="string", length=255, nullable=true)
     */
    private $socialReason;

    /**
     * @var string|null
     *
     * @ORM\Column(name="merchant_id", type="string", length=255, nullable=true)
     */
    private $merchantId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var array|null
     *
     * @ORM\Column(name="coordinates", type="json_array", nullable=true)
     */
    private $coordinates;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commercial_name", type="string", length=255, nullable=true)
     */
    private $commercialName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="opening_year", type="integer", nullable=true)
     */
    private $openingYear;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="personalized_mail", type="boolean", nullable=true)
     */
    private $personalizedMail;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="personalized_interface", type="boolean", nullable=true)
     */
    private $personalizedInterface;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var float|null
     *
     * @ORM\Column(name="credit_initial", type="float", precision=10, scale=0, nullable=true)
     */
    private $creditInitial;

    /**
     * @var float|null
     *
     * @ORM\Column(name="credit_available", type="float", precision=10, scale=0, nullable=true)
     */
    private $creditAvailable;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="registration_date", type="date", nullable=true)
     */
    private $registrationDate;

    /**
     * @var int
     *
     * @ORM\Column(name="status_agency", type="integer", nullable=false)
     */
    private $statusAgency = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby", type="integer", nullable=true)
     */
    private $createdby;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updatedby", type="integer", nullable=true)
     */
    private $updatedby;

    /**
     * @var string
     *
     * @ORM\Column(name="customize", type="string", length=255, nullable=false)
     */
    private $customize = '';

    /**
     * @var float|null
     *
     * @ORM\Column(name="navicu_gain", type="float", precision=10, scale=0, nullable=true)
     */
    private $navicuGain;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="sent_email_for_insufficient_credit", type="boolean", nullable=true)
     */
    private $sentEmailForInsufficientCredit = false;

    /**
     * @var int|null
     *
     * @ORM\Column(name="deactivate_reason", type="integer", nullable=true)
     */
    private $deactivateReason = '0';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="sent_email_for_credit_less_than", type="boolean", nullable=true)
     */
    private $sentEmailForCreditLessThan = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="have_credit_zero", type="boolean", nullable=false)
     */
    private $haveCreditZero = false;

    /**
     * @var float|null
     *
     * @ORM\Column(name="markup_amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $markupAmount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="markup_increment_type", type="integer", nullable=true)
     */
    private $markupIncrementType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="breakdown", type="integer", nullable=true)
     */
    private $breakdown;

    /**
     * @var \Subdomain
     *
     * @ORM\ManyToOne(targetEntity="Subdomain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subdomain_id", referencedColumnName="id")
     * })
     */
    private $subdomain;

    /**
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logo_id", referencedColumnName="id")
     * })
     */
    private $logo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AavvAdditionalQuota", mappedBy="aavv")
     */
    private $additionalQuota;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->additionalQuota = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRif(): ?string
    {
        return $this->rif;
    }

    public function setRif(?string $rif): self
    {
        $this->rif = $rif;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(?string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }

    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(?string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }

    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    public function setSocialReason(?string $socialReason): self
    {
        $this->socialReason = $socialReason;

        return $this;
    }

    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    public function setMerchantId(?string $merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function getCommercialName(): ?string
    {
        return $this->commercialName;
    }

    public function setCommercialName(?string $commercialName): self
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    public function getOpeningYear(): ?int
    {
        return $this->openingYear;
    }

    public function setOpeningYear(?int $openingYear): self
    {
        $this->openingYear = $openingYear;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPersonalizedMail(): ?bool
    {
        return $this->personalizedMail;
    }

    public function setPersonalizedMail(?bool $personalizedMail): self
    {
        $this->personalizedMail = $personalizedMail;

        return $this;
    }

    public function getPersonalizedInterface(): ?bool
    {
        return $this->personalizedInterface;
    }

    public function setPersonalizedInterface(?bool $personalizedInterface): self
    {
        $this->personalizedInterface = $personalizedInterface;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreditInitial(): ?float
    {
        return $this->creditInitial;
    }

    public function setCreditInitial(?float $creditInitial): self
    {
        $this->creditInitial = $creditInitial;

        return $this;
    }

    public function getCreditAvailable(): ?float
    {
        return $this->creditAvailable;
    }

    public function setCreditAvailable(?float $creditAvailable): self
    {
        $this->creditAvailable = $creditAvailable;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(?\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getStatusAgency(): ?int
    {
        return $this->statusAgency;
    }

    public function setStatusAgency(int $statusAgency): self
    {
        $this->statusAgency = $statusAgency;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getCreatedby(): ?int
    {
        return $this->createdby;
    }

    public function setCreatedby(?int $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getUpdatedby(): ?int
    {
        return $this->updatedby;
    }

    public function setUpdatedby(?int $updatedby): self
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    public function getCustomize(): ?string
    {
        return $this->customize;
    }

    public function setCustomize(string $customize): self
    {
        $this->customize = $customize;

        return $this;
    }

    public function getNavicuGain(): ?float
    {
        return $this->navicuGain;
    }

    public function setNavicuGain(?float $navicuGain): self
    {
        $this->navicuGain = $navicuGain;

        return $this;
    }

    public function getSentEmailForInsufficientCredit(): ?bool
    {
        return $this->sentEmailForInsufficientCredit;
    }

    public function setSentEmailForInsufficientCredit(?bool $sentEmailForInsufficientCredit): self
    {
        $this->sentEmailForInsufficientCredit = $sentEmailForInsufficientCredit;

        return $this;
    }

    public function getDeactivateReason(): ?int
    {
        return $this->deactivateReason;
    }

    public function setDeactivateReason(?int $deactivateReason): self
    {
        $this->deactivateReason = $deactivateReason;

        return $this;
    }

    public function getSentEmailForCreditLessThan(): ?bool
    {
        return $this->sentEmailForCreditLessThan;
    }

    public function setSentEmailForCreditLessThan(?bool $sentEmailForCreditLessThan): self
    {
        $this->sentEmailForCreditLessThan = $sentEmailForCreditLessThan;

        return $this;
    }

    public function getHaveCreditZero(): ?bool
    {
        return $this->haveCreditZero;
    }

    public function setHaveCreditZero(bool $haveCreditZero): self
    {
        $this->haveCreditZero = $haveCreditZero;

        return $this;
    }

    public function getMarkupAmount(): ?float
    {
        return $this->markupAmount;
    }

    public function setMarkupAmount(?float $markupAmount): self
    {
        $this->markupAmount = $markupAmount;

        return $this;
    }

    public function getMarkupIncrementType(): ?int
    {
        return $this->markupIncrementType;
    }

    public function setMarkupIncrementType(?int $markupIncrementType): self
    {
        $this->markupIncrementType = $markupIncrementType;

        return $this;
    }

    public function getBreakdown(): ?int
    {
        return $this->breakdown;
    }

    public function setBreakdown(?int $breakdown): self
    {
        $this->breakdown = $breakdown;

        return $this;
    }

    public function getSubdomain(): ?Subdomain
    {
        return $this->subdomain;
    }

    public function setSubdomain(?Subdomain $subdomain): self
    {
        $this->subdomain = $subdomain;

        return $this;
    }

    public function getLogo(): ?Document
    {
        return $this->logo;
    }

    public function setLogo(?Document $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|AavvAdditionalQuota[]
     */
    public function getAdditionalQuota(): Collection
    {
        return $this->additionalQuota;
    }

    public function addAdditionalQuotum(AavvAdditionalQuota $additionalQuotum): self
    {
        if (!$this->additionalQuota->contains($additionalQuotum)) {
            $this->additionalQuota[] = $additionalQuotum;
            $additionalQuotum->addAavv($this);
        }

        return $this;
    }

    public function removeAdditionalQuotum(AavvAdditionalQuota $additionalQuotum): self
    {
        if ($this->additionalQuota->contains($additionalQuotum)) {
            $this->additionalQuota->removeElement($additionalQuotum);
            $additionalQuotum->removeAavv($this);
        }

        return $this;
    }

}
