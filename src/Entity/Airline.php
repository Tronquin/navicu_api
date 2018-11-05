<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Airline
 *
 * @ORM\Table(name="airline", uniqueConstraints={@ORM\UniqueConstraint(name="unique_iata_airline", columns={"iso"}), @ORM\UniqueConstraint(name="unique_slug_airline", columns={"slug"})}, indexes={@ORM\Index(name="IDX_EC141EF864D218E", columns={"location_id"}), @ORM\Index(name="IDX_EC141EF8F98F144A", columns={"logo_id"}), @ORM\Index(name="IDX_EC141EF838248176", columns={"currency_id"})})
 * @ORM\Entity
 */
class Airline
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airline_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="iso", type="string", length=4, nullable=false)
     */
    private $iso;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rif", type="string", length=255, nullable=true)
     */
    private $rif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default"="1"})
     */
    private $status = '1';

    /**
     * @var string|null
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=true)
     */
    private $publicId;

    /**
     * @var float|null
     *
     * @ORM\Column(name="credit_available", type="float", precision=10, scale=0, nullable=true)
     */
    private $creditAvailable = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="credit_initial", type="float", precision=10, scale=0, nullable=true)
     */
    private $creditInitial = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="invoice_type", type="integer", nullable=false)
     */
    private $invoiceType = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="payment_days", type="integer", nullable=false)
     */
    private $paymentDays = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="invoice_days", type="integer", nullable=false)
     */
    private $invoiceDays = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="registration_date", type="date", nullable=true)
     */
    private $registrationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="join_date", type="date", nullable=true)
     */
    private $joinDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="billing_date", type="date", nullable=true)
     */
    private $billingDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="notification_days", type="integer", nullable=true)
     */
    private $notificationDays;

    /**
     * @var float|null
     *
     * @ORM\Column(name="national_commission", type="float", precision=10, scale=0, nullable=true)
     */
    private $nationalCommission = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="international_commission", type="float", precision=10, scale=0, nullable=true)
     */
    private $internationalCommission = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="international_credit_initial", type="float", precision=10, scale=0, nullable=true)
     */
    private $internationalCreditInitial;

    /**
     * @var float|null
     *
     * @ORM\Column(name="international_credit_available", type="float", precision=10, scale=0, nullable=true)
     */
    private $internationalCreditAvailable;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIso(): ?string
    {
        return $this->iso;
    }

    public function setIso(string $iso): self
    {
        $this->iso = $iso;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(?string $publicId): self
    {
        $this->publicId = $publicId;

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

    public function getCreditInitial(): ?float
    {
        return $this->creditInitial;
    }

    public function setCreditInitial(?float $creditInitial): self
    {
        $this->creditInitial = $creditInitial;

        return $this;
    }

    public function getInvoiceType(): ?int
    {
        return $this->invoiceType;
    }

    public function setInvoiceType(int $invoiceType): self
    {
        $this->invoiceType = $invoiceType;

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

    public function getPaymentDays(): ?int
    {
        return $this->paymentDays;
    }

    public function setPaymentDays(int $paymentDays): self
    {
        $this->paymentDays = $paymentDays;

        return $this;
    }

    public function getInvoiceDays(): ?int
    {
        return $this->invoiceDays;
    }

    public function setInvoiceDays(int $invoiceDays): self
    {
        $this->invoiceDays = $invoiceDays;

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

    public function getJoinDate(): ?\DateTimeInterface
    {
        return $this->joinDate;
    }

    public function setJoinDate(?\DateTimeInterface $joinDate): self
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    public function getBillingDate(): ?\DateTimeInterface
    {
        return $this->billingDate;
    }

    public function setBillingDate(?\DateTimeInterface $billingDate): self
    {
        $this->billingDate = $billingDate;

        return $this;
    }

    public function getNotificationDays(): ?int
    {
        return $this->notificationDays;
    }

    public function setNotificationDays(?int $notificationDays): self
    {
        $this->notificationDays = $notificationDays;

        return $this;
    }

    public function getNationalCommission(): ?float
    {
        return $this->nationalCommission;
    }

    public function setNationalCommission(?float $nationalCommission): self
    {
        $this->nationalCommission = $nationalCommission;

        return $this;
    }

    public function getInternationalCommission(): ?float
    {
        return $this->internationalCommission;
    }

    public function setInternationalCommission(?float $internationalCommission): self
    {
        $this->internationalCommission = $internationalCommission;

        return $this;
    }

    public function getInternationalCreditInitial(): ?float
    {
        return $this->internationalCreditInitial;
    }

    public function setInternationalCreditInitial(?float $internationalCreditInitial): self
    {
        $this->internationalCreditInitial = $internationalCreditInitial;

        return $this;
    }

    public function getInternationalCreditAvailable(): ?float
    {
        return $this->internationalCreditAvailable;
    }

    public function setInternationalCreditAvailable(?float $internationalCreditAvailable): self
    {
        $this->internationalCreditAvailable = $internationalCreditAvailable;

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

    public function getLogo(): ?Document
    {
        return $this->logo;
    }

    public function setLogo(?Document $logo): self
    {
        $this->logo = $logo;

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
