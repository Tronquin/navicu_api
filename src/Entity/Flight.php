<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flight
 *
 * @ORM\Table(name="flight", indexes={@ORM\Index(name="idx_c257e60e6956883f", columns={"currency"}), @ORM\Index(name="idx_c257e60ed787d2c4", columns={"airport_to"}), @ORM\Index(name="idx_c257e60ef73df7ae", columns={"flight_reservation"}), @ORM\Index(name="idx_c257e60eec141ef8", columns={"airline"}), @ORM\Index(name="idx_c257e60eb91aa170", columns={"airport_from"}), @ORM\Index(name="IDX_C257E60E4A096F2E", columns={"original_currency"}), @ORM\Index(name="IDX_C257E60E6B1C669", columns={"flight_lock"})})
 * @ORM\Entity
 */
class Flight
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_time", type="datetime", nullable=false)
     */
    private $departureTime;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=false)
     */
    private $duration;

    /**
     * @var bool
     *
     * @ORM\Column(name="return_flight", type="boolean", nullable=false)
     */
    private $returnFlight = false;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_time", type="datetime", nullable=false)
     */
    private $arrivalTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_rate", type="string", length=255, nullable=true)
     */
    private $typeRate;

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
     * @var float
     *
     * @ORM\Column(name="original_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $originalPrice;

    /**
     * @var float|null
     *
     * @ORM\Column(name="type_rate_increment", type="float", precision=10, scale=0, nullable=true)
     */
    private $typeRateIncrement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_rate_increment_type", type="string", length=255, nullable=true)
     */
    private $typeRateIncrementType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_rate_increment_currency", type="string", length=255, nullable=true)
     */
    private $typeRateIncrementCurrency;

    /**
     * @var float|null
     *
     * @ORM\Column(name="type_rate_percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $typeRatePercentage;

    /**
     * @var bool
     *
     * @ORM\Column(name="roundtrip", type="boolean", nullable=false)
     */
    private $roundtrip = false;

    /**
     * @var float|null
     *
     * @ORM\Column(name="airline_commission", type="float", precision=10, scale=0, nullable=true)
     */
    private $airlineCommission = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="original_price_no_tax", type="float", precision=10, scale=0, nullable=true)
     */
    private $originalPriceNoTax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gds_taxes", type="string", length=255, nullable=true)
     */
    private $gdsTaxes;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price_no_tax", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceNoTax;

    /**
     * @var float
     *
     * @ORM\Column(name="converted_price", type="float", precision=10, scale=0, nullable=false)
     */
    private $convertedPrice = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string", length=255, nullable=false)
     */
    private $provider;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cabin", type="string", length=255, nullable=true)
     */
    private $cabin;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_refundable", type="boolean", nullable=true)
     */
    private $isRefundable;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="technical_stop", type="boolean", nullable=true)
     */
    private $technicalStop;

    /**
     * @var float
     *
     * @ORM\Column(name="increment_consolidator", type="float", precision=10, scale=0, nullable=false)
     */
    private $incrementConsolidator = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal_no_extra_increment", type="float", precision=10, scale=0, nullable=false)
     */
    private $subtotalNoExtraIncrement = '0';

    /**
     * @var float
     *
     * @ORM\Column(name="tax_total", type="float", precision=10, scale=0, nullable=false)
     */
    private $taxTotal = '0';

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airport_from", referencedColumnName="id")
     * })
     */
    private $airportFrom;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airport_to", referencedColumnName="id")
     * })
     */
    private $airportTo;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline", referencedColumnName="id")
     * })
     */
    private $airline;

    /**
     * @var \FlightReservation
     *
     * @ORM\ManyToOne(targetEntity="FlightReservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation", referencedColumnName="id")
     * })
     */
    private $flightReservation;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="original_currency", referencedColumnName="id")
     * })
     */
    private $originalCurrency;

    /**
     * @var \FlightLock
     *
     * @ORM\ManyToOne(targetEntity="FlightLock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_lock", referencedColumnName="id")
     * })
     */
    private $flightLock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeInterface $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getReturnFlight(): ?bool
    {
        return $this->returnFlight;
    }

    public function setReturnFlight(bool $returnFlight): self
    {
        $this->returnFlight = $returnFlight;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(\DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getTypeRate(): ?string
    {
        return $this->typeRate;
    }

    public function setTypeRate(?string $typeRate): self
    {
        $this->typeRate = $typeRate;

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

    public function getOriginalPrice(): ?float
    {
        return $this->originalPrice;
    }

    public function setOriginalPrice(float $originalPrice): self
    {
        $this->originalPrice = $originalPrice;

        return $this;
    }

    public function getTypeRateIncrement(): ?float
    {
        return $this->typeRateIncrement;
    }

    public function setTypeRateIncrement(?float $typeRateIncrement): self
    {
        $this->typeRateIncrement = $typeRateIncrement;

        return $this;
    }

    public function getTypeRateIncrementType(): ?string
    {
        return $this->typeRateIncrementType;
    }

    public function setTypeRateIncrementType(?string $typeRateIncrementType): self
    {
        $this->typeRateIncrementType = $typeRateIncrementType;

        return $this;
    }

    public function getTypeRateIncrementCurrency(): ?string
    {
        return $this->typeRateIncrementCurrency;
    }

    public function setTypeRateIncrementCurrency(?string $typeRateIncrementCurrency): self
    {
        $this->typeRateIncrementCurrency = $typeRateIncrementCurrency;

        return $this;
    }

    public function getTypeRatePercentage(): ?float
    {
        return $this->typeRatePercentage;
    }

    public function setTypeRatePercentage(?float $typeRatePercentage): self
    {
        $this->typeRatePercentage = $typeRatePercentage;

        return $this;
    }

    public function getRoundtrip(): ?bool
    {
        return $this->roundtrip;
    }

    public function setRoundtrip(bool $roundtrip): self
    {
        $this->roundtrip = $roundtrip;

        return $this;
    }

    public function getAirlineCommission(): ?float
    {
        return $this->airlineCommission;
    }

    public function setAirlineCommission(?float $airlineCommission): self
    {
        $this->airlineCommission = $airlineCommission;

        return $this;
    }

    public function getOriginalPriceNoTax(): ?float
    {
        return $this->originalPriceNoTax;
    }

    public function setOriginalPriceNoTax(?float $originalPriceNoTax): self
    {
        $this->originalPriceNoTax = $originalPriceNoTax;

        return $this;
    }

    public function getGdsTaxes(): ?string
    {
        return $this->gdsTaxes;
    }

    public function setGdsTaxes(?string $gdsTaxes): self
    {
        $this->gdsTaxes = $gdsTaxes;

        return $this;
    }

    public function getPriceNoTax(): ?float
    {
        return $this->priceNoTax;
    }

    public function setPriceNoTax(?float $priceNoTax): self
    {
        $this->priceNoTax = $priceNoTax;

        return $this;
    }

    public function getConvertedPrice(): ?float
    {
        return $this->convertedPrice;
    }

    public function setConvertedPrice(float $convertedPrice): self
    {
        $this->convertedPrice = $convertedPrice;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getCabin(): ?string
    {
        return $this->cabin;
    }

    public function setCabin(?string $cabin): self
    {
        $this->cabin = $cabin;

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

    public function getTechnicalStop(): ?bool
    {
        return $this->technicalStop;
    }

    public function setTechnicalStop(?bool $technicalStop): self
    {
        $this->technicalStop = $technicalStop;

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

    public function getSubtotalNoExtraIncrement(): ?float
    {
        return $this->subtotalNoExtraIncrement;
    }

    public function setSubtotalNoExtraIncrement(float $subtotalNoExtraIncrement): self
    {
        $this->subtotalNoExtraIncrement = $subtotalNoExtraIncrement;

        return $this;
    }

    public function getTaxTotal(): ?float
    {
        return $this->taxTotal;
    }

    public function setTaxTotal(float $taxTotal): self
    {
        $this->taxTotal = $taxTotal;

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

    public function getAirportFrom(): ?Airport
    {
        return $this->airportFrom;
    }

    public function setAirportFrom(?Airport $airportFrom): self
    {
        $this->airportFrom = $airportFrom;

        return $this;
    }

    public function getAirportTo(): ?Airport
    {
        return $this->airportTo;
    }

    public function setAirportTo(?Airport $airportTo): self
    {
        $this->airportTo = $airportTo;

        return $this;
    }

    public function getAirline(): ?Airline
    {
        return $this->airline;
    }

    public function setAirline(?Airline $airline): self
    {
        $this->airline = $airline;

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

    public function getOriginalCurrency(): ?CurrencyType
    {
        return $this->originalCurrency;
    }

    public function setOriginalCurrency(?CurrencyType $originalCurrency): self
    {
        $this->originalCurrency = $originalCurrency;

        return $this;
    }

    public function getFlightLock(): ?FlightLock
    {
        return $this->flightLock;
    }

    public function setFlightLock(?FlightLock $flightLock): self
    {
        $this->flightLock = $flightLock;

        return $this;
    }


}
