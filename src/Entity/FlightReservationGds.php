<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightReservationGds
 *
 * @ORM\Table(name="flight_reservation_gds", indexes={@ORM\Index(name="IDX_6321B70A18E5767C", columns={"currency_type_id"}), @ORM\Index(name="IDX_6321B70A280B5C9C", columns={"gds_id"}), @ORM\Index(name="IDX_6321B70A7E6A667", columns={"flight_type_schedule_id"}), @ORM\Index(name="IDX_6321B70AA0C1743", columns={"airline_provider"}), @ORM\Index(name="IDX_6321B70AB6328EC6", columns={"flight_reservation_id"})})
 * @ORM\Entity
 */
class FlightReservationGds
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_reservation_gds_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="book_code", type="string", length=12, nullable=true)
     */
    private $bookCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=false)
     */
    private $reservationDate;

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
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="taxes", type="string", length=255, nullable=true)
     */
    private $taxes;

    /**
     * @var float
     *
     * @ORM\Column(name="increment_consolidator", type="float", precision=10, scale=0, nullable=false)
     */
    private $incrementConsolidator = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="markup_increment_amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $markupIncrementAmount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="markup_increment_type", type="string", length=255, nullable=true)
     */
    private $markupIncrementType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="markup_currency", type="string", length=255, nullable=true)
     */
    private $markupCurrency;

    /**
     * @var float|null
     *
     * @ORM\Column(name="airline_commision", type="float", precision=10, scale=0, nullable=true)
     */
    private $airlineCommision;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_refundable", type="boolean", nullable=true)
     */
    private $isRefundable;

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
     * @var \Gds
     *
     * @ORM\ManyToOne(targetEntity="Gds")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gds_id", referencedColumnName="id")
     * })
     */
    private $gds;

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
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_provider", referencedColumnName="id")
     * })
     */
    private $airlineProvider;

    /**
     * @var \FlightReservation
     *
     * @ORM\ManyToOne(targetEntity="FlightReservation", inversedBy="gdsReservations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation_id", referencedColumnName="id")
     * })
     */
    private $flightReservation;

        /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="Flight", mappedBy="flight") 
     */
    private $flights;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookCode(): ?string
    {
        return $this->bookCode;
    }

    public function setBookCode(?string $bookCode): self
    {
        $this->bookCode = $bookCode;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTaxes(): ?string
    {
        return $this->taxes;
    }

    public function setTaxes(?string $taxes): self
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getIncrementConsolidator(): ?float
    {
        return $this->incrementConsolidator;
    }

    public function setIncrementConsolidator(float $incrementConsolidator): self
    {
        $this->incrementConsolidator = $incrementConsolidator;

        return $this;
    }

    public function getMarkupIncrementAmount(): ?float
    {
        return $this->markupIncrementAmount;
    }

    public function setMarkupIncrementAmount(?float $markupIncrementAmount): self
    {
        $this->markupIncrementAmount = $markupIncrementAmount;

        return $this;
    }

    public function getMarkupIncrementType(): ?string
    {
        return $this->markupIncrementType;
    }

    public function setMarkupIncrementType(?string $markupIncrementType): self
    {
        $this->markupIncrementType = $markupIncrementType;

        return $this;
    }

    public function getMarkupCurrency(): ?string
    {
        return $this->markupCurrency;
    }

    public function setMarkupCurrency(?string $markupCurrency): self
    {
        $this->markupCurrency = $markupCurrency;

        return $this;
    }

    public function getAirlineCommision(): ?float
    {
        return $this->airlineCommision;
    }

    public function setAirlineCommision(?float $airlineCommision): self
    {
        $this->airlineCommision = $airlineCommision;

        return $this;
    }

    public function getIsRefundable(): ?bool
    {
        return $this->isRefundable;
    }

    public function setIsRefundable(?bool $isRefundable): self
    {
        $this->isRefundable = $isRefundable;

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

    public function getGds(): ?Gds
    {
        return $this->gds;
    }

    public function setGds(?Gds $gds): self
    {
        $this->gds = $gds;

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

    public function getAirlineProvider(): ?Airline
    {
        return $this->airlineProvider;
    }

    public function setAirlineProvider(?Airline $airlineProvider): self
    {
        $this->airlineProvider = $airlineProvider;

        return $this;
    }

    public function getFlightReservation(): ?FlightReservation
    {
        return $this->flightReservation;
    }

    public function setFlightReservation(?FlightReservation $flightReservation): self
    {
        $this->flightReservation = $flightReservation;

        return $this;
    }


}
