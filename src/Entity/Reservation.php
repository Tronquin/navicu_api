<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_42c8495578da5ff", columns={"current_state"})}, indexes={@ORM\Index(name="idx_42c84955f30c1afa", columns={"aavv_reservation_group_id"}), @ORM\Index(name="idx_42c8495587414140", columns={"property_currency_id"}), @ORM\Index(name="idx_42c84955549213ec", columns={"property_id"}), @ORM\Index(name="idx_42c8495519eb6921", columns={"client_id"}), @ORM\Index(name="IDX_42C8495538248176", columns={"currency_id"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="reservation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=false)
     */
    private $publicId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_check_in", type="date", nullable=false)
     */
    private $dateCheckIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_check_out", type="date", nullable=false)
     */
    private $dateCheckOut;

    /**
     * @var int
     *
     * @ORM\Column(name="child_number", type="integer", nullable=false)
     */
    private $childNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="adult_number", type="integer", nullable=false)
     */
    private $adultNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="special_request", type="string", length=255, nullable=true)
     */
    private $specialRequest;

    /**
     * @var float
     *
     * @ORM\Column(name="total_to_pay", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalToPay;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hash_url", type="string", length=255, nullable=true)
     */
    private $hashUrl;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=true)
     */
    private $reservationDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="payment_type", type="integer", nullable=true)
     */
    private $paymentType;

    /**
     * @var array|null
     *
     * @ORM\Column(name="guest", type="json_array", nullable=true)
     */
    private $guest;

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=0, nullable=false)
     */
    private $tax = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="discount_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $discountRate = '0';

    /**
     * @var array|null
     *
     * @ORM\Column(name="currency_convertion_information", type="json_array", nullable=true)
     */
    private $currencyConvertionInformation;

    /**
     * @var float|null
     *
     * @ORM\Column(name="discount_rate_aavv", type="float", precision=10, scale=0, nullable=true)
     */
    private $discountRateAavv = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_prefix", type="string", length=4, nullable=true)
     */
    private $codePrefix;

    /**
     * @var int|null
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_address", type="string", length=16, nullable=true)
     */
    private $ipAddress;

    /**
     * @var float|null
     *
     * @ORM\Column(name="markup_amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $markupAmount = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="markup_type", type="integer", nullable=true)
     */
    private $markupType;

    /**
     * @var float|null
     *
     * @ORM\Column(name="markup_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $markupRate;

    /**
     * @var float
     *
     * @ORM\Column(name="discount_pandco", type="float", precision=10, scale=0, nullable=false)
     */
    private $discountPandco = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="channel", type="string", length=255, nullable=true)
     */
    private $channel;

    /**
     * @var float
     *
     * @ORM\Column(name="discount_rate_by_foreing_currency", type="float", precision=10, scale=0, nullable=false)
     */
    private $discountRateByForeingCurrency = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @var \ClienteProfile
     *
     * @ORM\ManyToOne(targetEntity="ClienteProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     */
    private $client;

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
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @var \ReservationChangeHistory
     *
     * @ORM\ManyToOne(targetEntity="ReservationChangeHistory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="current_state", referencedColumnName="id")
     * })
     */
    private $currentState;

    /**
     * @var \ReservationGroup
     *
     * @ORM\ManyToOne(targetEntity="ReservationGroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_reservation_group_id", referencedColumnName="id")
     * })
     */
    private $aavvReservationGroup;

    /**
     * @var \PropertyCurrency
     *
     * @ORM\ManyToOne(targetEntity="PropertyCurrency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_currency_id", referencedColumnName="id")
     * })
     */
    private $propertyCurrency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }

    public function getDateCheckIn(): ?\DateTimeInterface
    {
        return $this->dateCheckIn;
    }

    public function setDateCheckIn(\DateTimeInterface $dateCheckIn): self
    {
        $this->dateCheckIn = $dateCheckIn;

        return $this;
    }

    public function getDateCheckOut(): ?\DateTimeInterface
    {
        return $this->dateCheckOut;
    }

    public function setDateCheckOut(\DateTimeInterface $dateCheckOut): self
    {
        $this->dateCheckOut = $dateCheckOut;

        return $this;
    }

    public function getChildNumber(): ?int
    {
        return $this->childNumber;
    }

    public function setChildNumber(int $childNumber): self
    {
        $this->childNumber = $childNumber;

        return $this;
    }

    public function getAdultNumber(): ?int
    {
        return $this->adultNumber;
    }

    public function setAdultNumber(int $adultNumber): self
    {
        $this->adultNumber = $adultNumber;

        return $this;
    }

    public function getSpecialRequest(): ?string
    {
        return $this->specialRequest;
    }

    public function setSpecialRequest(?string $specialRequest): self
    {
        $this->specialRequest = $specialRequest;

        return $this;
    }

    public function getTotalToPay(): ?float
    {
        return $this->totalToPay;
    }

    public function setTotalToPay(float $totalToPay): self
    {
        $this->totalToPay = $totalToPay;

        return $this;
    }

    public function getHashUrl(): ?string
    {
        return $this->hashUrl;
    }

    public function setHashUrl(?string $hashUrl): self
    {
        $this->hashUrl = $hashUrl;

        return $this;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(?\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

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

    public function getPaymentType(): ?int
    {
        return $this->paymentType;
    }

    public function setPaymentType(?int $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getGuest()
    {
        return $this->guest;
    }

    public function setGuest($guest): self
    {
        $this->guest = $guest;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(float $discountRate): self
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    public function getCurrencyConvertionInformation()
    {
        return $this->currencyConvertionInformation;
    }

    public function setCurrencyConvertionInformation($currencyConvertionInformation): self
    {
        $this->currencyConvertionInformation = $currencyConvertionInformation;

        return $this;
    }

    public function getDiscountRateAavv(): ?float
    {
        return $this->discountRateAavv;
    }

    public function setDiscountRateAavv(?float $discountRateAavv): self
    {
        $this->discountRateAavv = $discountRateAavv;

        return $this;
    }

    public function getCodePrefix(): ?string
    {
        return $this->codePrefix;
    }

    public function setCodePrefix(?string $codePrefix): self
    {
        $this->codePrefix = $codePrefix;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

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

    public function getMarkupType(): ?int
    {
        return $this->markupType;
    }

    public function setMarkupType(?int $markupType): self
    {
        $this->markupType = $markupType;

        return $this;
    }

    public function getMarkupRate(): ?float
    {
        return $this->markupRate;
    }

    public function setMarkupRate(?float $markupRate): self
    {
        $this->markupRate = $markupRate;

        return $this;
    }

    public function getDiscountPandco(): ?float
    {
        return $this->discountPandco;
    }

    public function setDiscountPandco(float $discountPandco): self
    {
        $this->discountPandco = $discountPandco;

        return $this;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function setChannel(?string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getDiscountRateByForeingCurrency(): ?float
    {
        return $this->discountRateByForeingCurrency;
    }

    public function setDiscountRateByForeingCurrency(float $discountRateByForeingCurrency): self
    {
        $this->discountRateByForeingCurrency = $discountRateByForeingCurrency;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getClient(): ?ClienteProfile
    {
        return $this->client;
    }

    public function setClient(?ClienteProfile $client): self
    {
        $this->client = $client;

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

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getCurrentState(): ?ReservationChangeHistory
    {
        return $this->currentState;
    }

    public function setCurrentState(?ReservationChangeHistory $currentState): self
    {
        $this->currentState = $currentState;

        return $this;
    }

    public function getAavvReservationGroup(): ?ReservationGroup
    {
        return $this->aavvReservationGroup;
    }

    public function setAavvReservationGroup(?ReservationGroup $aavvReservationGroup): self
    {
        $this->aavvReservationGroup = $aavvReservationGroup;

        return $this;
    }

    public function getPropertyCurrency(): ?PropertyCurrency
    {
        return $this->propertyCurrency;
    }

    public function setPropertyCurrency(?PropertyCurrency $propertyCurrency): self
    {
        $this->propertyCurrency = $propertyCurrency;

        return $this;
    }


}
