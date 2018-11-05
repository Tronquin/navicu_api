<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DeniedReservation
 *
 * @ORM\Table(name="denied_reservation", indexes={@ORM\Index(name="idx_80282e71549213ec", columns={"property_id"}), @ORM\Index(name="idx_80282e7119eb6921", columns={"client_id"})})
 * @ORM\Entity
 */
class DeniedReservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="denied_reservation_id_seq", allocationSize=1, initialValue=1)
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
     * @var float
     *
     * @ORM\Column(name="discount_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $discountRate = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=0, nullable=false)
     */
    private $tax = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=true)
     */
    private $reservationDate;

    /**
     * @var array|null
     *
     * @ORM\Column(name="guest", type="json_array", nullable=true)
     */
    private $guest;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="payment_type", type="integer", nullable=false)
     */
    private $paymentType;

    /**
     * @var array|null
     *
     * @ORM\Column(name="reservation_packages", type="json_array", nullable=true)
     */
    private $reservationPackages;

    /**
     * @var array|null
     *
     * @ORM\Column(name="payments", type="json_array", nullable=true)
     */
    private $payments;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

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

    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(float $discountRate): self
    {
        $this->discountRate = $discountRate;

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

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(?\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentType(): ?int
    {
        return $this->paymentType;
    }

    public function setPaymentType(int $paymentType): self
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    public function getReservationPackages()
    {
        return $this->reservationPackages;
    }

    public function setReservationPackages($reservationPackages): self
    {
        $this->reservationPackages = $reservationPackages;

        return $this;
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function setPayments($payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }


}
