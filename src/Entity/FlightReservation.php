<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightReservation
 *
 * @ORM\Table(name="flight_reservation", indexes={@ORM\Index(name="IDX_F73DF7AE18E5767C", columns={"currency_type_id"}), @ORM\Index(name="IDX_F73DF7AE7E6A667", columns={"flight_type_schedule_id"}), @ORM\Index(name="IDX_F73DF7AEF3EFD182", columns={"flight_class_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FlightReservationRepository"))
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
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=false)
     */
    private $reservationDate;

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
     * @var int|null
     *
     * @ORM\Column(name="inf_number", type="integer", nullable=true)
     */
    private $infNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ins_number", type="integer", nullable=true)
     */
    private $insNumber;

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal_no_extra_increment", type="float", precision=10, scale=0, nullable=false)
     */
    private $subtotalNoExtraIncrement = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal", type="float", precision=10, scale=0, nullable=false)
     */
    private $subtotal = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float", precision=10, scale=0, nullable=false)
     */
    private $tax = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="increment_expenses", type="float", precision=10, scale=0, nullable=false)
     */
    private $incrementExpenses = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="increment_guarantee", type="float", precision=10, scale=0, nullable=false)
     */
    private $incrementGuarantee = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float", precision=10, scale=0, nullable=false)
     */
    private $discount = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=true)
     */
    private $total;

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
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_type_id", referencedColumnName="id")
     * })
     */
    private $currencyType;

    /**
     * @var \FlightTypeSchedule
     *
     * @ORM\ManyToOne(targetEntity="FlightTypeSchedule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_type_schedule_id", referencedColumnName="id")
     * })
     */
    private $flightTypeSchedule;

    /**
     * @var \FlightClass
     *
     * @ORM\ManyToOne(targetEntity="FlightClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_class_id", referencedColumnName="id")
     * })
     */
    private $flightClass;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="FlightReservationGds", mappedBy="flightReservation") 
     */
    private $gdsReservations;



    public function __construct()
    {
        $this->$gdsReservations = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getInfNumber(): ?int
    {
        return $this->infNumber;
    }

    public function setInfNumber(?int $infNumber): self
    {
        $this->infNumber = $infNumber;

        return $this;
    }

    public function getInsNumber(): ?int
    {
        return $this->insNumber;
    }

    public function setInsNumber(?int $insNumber): self
    {
        $this->insNumber = $insNumber;

        return $this;
    }

    public function getSubtotalNoExtraIncrement(): ?float
    {
        return $this->subtotalNoExtraIncrement;
    }

    public function setSubtotalNoExtraIncrement(float $subtotalNoExtraIncrement): self
    {
        $this->subtotalNoExtraIncrement = $subtotalNoExtraIncrement;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(float $subtotal): self
    {
        $this->subtotal = $subtotal;

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

    public function getIncrementExpenses(): ?float
    {
        return $this->incrementExpenses;
    }

    public function setIncrementExpenses(float $incrementExpenses): self
    {
        $this->incrementExpenses = $incrementExpenses;

        return $this;
    }

    public function getIncrementGuarantee(): ?float
    {
        return $this->incrementGuarantee;
    }

    public function setIncrementGuarantee(float $incrementGuarantee): self
    {
        $this->incrementGuarantee = $incrementGuarantee;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): self
    {
        $this->total = $total;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCurrencyType(): ?CurrencyType
    {
        return $this->currencyType;
    }

    public function setCurrencyType(?CurrencyType $currencyType): self
    {
        $this->currencyType = $currencyType;

        return $this;
    }

    public function getFlightTypeSchedule(): ?FlightTypeSchedule
    {
        return $this->flightTypeSchedule;
    }

    public function setFlightTypeSchedule(?FlightTypeSchedule $flightTypeSchedule): self
    {
        $this->flightTypeSchedule = $flightTypeSchedule;

        return $this;
    }

    public function getFlightClass(): ?FlightClass
    {
        return $this->flightClass;
    }

    public function setFlightClass(?FlightClass $flightClass): self
    {
        $this->flightClass = $flightClass;

        return $this;
    }

    /**
     * Add FlightReservationGds
     *   
     */
    public function addFlightReservationGds(FlightReservationGds $flightReservationGds)
    {
        $this->gdsReservations[] = $flightReservationGds;

        $flightReservationGds->setReservation($this);

        return $this;
    }

    public function removeFlightReservationGds(FlightReservationGds $flightReservationGds)
    {
        $this->gdsReservation->removeElement($flightReservationGds);
    }

    /**
    *
    */
    public function getFlightReservationGds()
    {
        return $this->gdsReservations;
    }


}
