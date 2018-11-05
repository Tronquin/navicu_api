<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightReservation
 *
 * @ORM\Table(name="flight_reservation", indexes={@ORM\Index(name="idx_f73df7ae6956883f", columns={"currency"})})
 * @ORM\Entity
 */
class FlightReservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_reservation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=false)
     */
    private $reservationDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var float|null
     *
     * @ORM\Column(name="total_to_pay", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalToPay;

    /**
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=false)
     */
    private $publicId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="child_number", type="integer", nullable=true)
     */
    private $childNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="adult_number", type="integer", nullable=true)
     */
    private $adultNumber;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=0, nullable=true)
     */
    private $tax;

    /**
     * @var float|null
     *
     * @ORM\Column(name="dollar_rate_covertion", type="float", precision=10, scale=0, nullable=true)
     */
    private $dollarRateCovertion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="currency_rate_covertion", type="float", precision=10, scale=0, nullable=true)
     */
    private $currencyRateCovertion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_return", type="string", length=255, nullable=true)
     */
    private $codeReturn;

    /**
     * @var int|null
     *
     * @ORM\Column(name="confirmation_status", type="integer", nullable=true)
     */
    private $confirmationStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmation_log", type="text", nullable=true)
     */
    private $confirmationLog;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true, options={"default"="WEB"})
     */
    private $type = 'WEB';

    /**
     * @var string|null
     *
     * @ORM\Column(name="payment_method", type="string", length=255, nullable=true, options={"default"="TDC"})
     */
    private $paymentMethod = 'TDC';

    /**
     * @var float|null
     *
     * @ORM\Column(name="dollar_rate_sell_covertion", type="float", precision=10, scale=0, nullable=true)
     */
    private $dollarRateSellCovertion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="currency_rate_sell_covertion", type="float", precision=10, scale=0, nullable=true)
     */
    private $currencyRateSellCovertion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_address", type="string", length=16, nullable=true)
     */
    private $ipAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency", referencedColumnName="id")
     * })
     */
    private $currency;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

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

    public function getTotalToPay(): ?float
    {
        return $this->totalToPay;
    }

    public function setTotalToPay(?float $totalToPay): self
    {
        $this->totalToPay = $totalToPay;

        return $this;
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

    public function getChildNumber(): ?int
    {
        return $this->childNumber;
    }

    public function setChildNumber(?int $childNumber): self
    {
        $this->childNumber = $childNumber;

        return $this;
    }

    public function getAdultNumber(): ?int
    {
        return $this->adultNumber;
    }

    public function setAdultNumber(?int $adultNumber): self
    {
        $this->adultNumber = $adultNumber;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(?float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getDollarRateCovertion(): ?float
    {
        return $this->dollarRateCovertion;
    }

    public function setDollarRateCovertion(?float $dollarRateCovertion): self
    {
        $this->dollarRateCovertion = $dollarRateCovertion;

        return $this;
    }

    public function getCurrencyRateCovertion(): ?float
    {
        return $this->currencyRateCovertion;
    }

    public function setCurrencyRateCovertion(?float $currencyRateCovertion): self
    {
        $this->currencyRateCovertion = $currencyRateCovertion;

        return $this;
    }

    public function getCodeReturn(): ?string
    {
        return $this->codeReturn;
    }

    public function setCodeReturn(?string $codeReturn): self
    {
        $this->codeReturn = $codeReturn;

        return $this;
    }

    public function getConfirmationStatus(): ?int
    {
        return $this->confirmationStatus;
    }

    public function setConfirmationStatus(?int $confirmationStatus): self
    {
        $this->confirmationStatus = $confirmationStatus;

        return $this;
    }

    public function getConfirmationLog(): ?string
    {
        return $this->confirmationLog;
    }

    public function setConfirmationLog(?string $confirmationLog): self
    {
        $this->confirmationLog = $confirmationLog;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getDollarRateSellCovertion(): ?float
    {
        return $this->dollarRateSellCovertion;
    }

    public function setDollarRateSellCovertion(?float $dollarRateSellCovertion): self
    {
        $this->dollarRateSellCovertion = $dollarRateSellCovertion;

        return $this;
    }

    public function getCurrencyRateSellCovertion(): ?float
    {
        return $this->currencyRateSellCovertion;
    }

    public function setCurrencyRateSellCovertion(?float $currencyRateSellCovertion): self
    {
        $this->currencyRateSellCovertion = $currencyRateSellCovertion;

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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

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
