<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightPayment
 *
 * @ORM\Table(name="flight_payment", indexes={@ORM\Index(name="idx_eec4679bf73df7ae", columns={"flight_reservation"}), @ORM\Index(name="idx_eec4679bad5dc05d", columns={"payment_type"})})
 * @ORM\Entity
 */
class FlightPayment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_payment_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var float|null
     *
     * @ORM\Column(name="amounttransferred", type="float", precision=10, scale=0, nullable=true)
     */
    private $amounttransferred;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="holder", type="string", length=255, nullable=true)
     */
    private $holder;

    /**
     * @var string|null
     *
     * @ORM\Column(name="holderid", type="string", length=255, nullable=true)
     */
    private $holderid;

    /**
     * @var array|null
     *
     * @ORM\Column(name="response", type="json_array", nullable=true)
     */
    private $response;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state = '0';

    /**
     * @var array|null
     *
     * @ORM\Column(name="currency_convertion_information", type="json_array", nullable=true)
     */
    private $currencyConvertionInformation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_address", type="string", length=15, nullable=true)
     */
    private $ipAddress;

    /**
     * @var array|null
     *
     * @ORM\Column(name="request", type="json_array", nullable=true)
     */
    private $request;

    /**
     * @var float|null
     *
     * @ORM\Column(name="payment_commision", type="float", precision=10, scale=0, nullable=true)
     */
    private $paymentCommision = '0';

    /**
     * @var \PaymentType
     *
     * @ORM\ManyToOne(targetEntity="PaymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_type", referencedColumnName="id")
     * })
     */
    private $paymentType;

    /**
     * @var \FlightReservation
     *
     * @ORM\ManyToOne(targetEntity="FlightReservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation", referencedColumnName="id")
     * })
     */
    private $flightReservation;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmounttransferred(): ?float
    {
        return $this->amounttransferred;
    }

    public function setAmounttransferred(?float $amounttransferred): self
    {
        $this->amounttransferred = $amounttransferred;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getHolder(): ?string
    {
        return $this->holder;
    }

    public function setHolder(?string $holder): self
    {
        $this->holder = $holder;

        return $this;
    }

    public function getHolderid(): ?string
    {
        return $this->holderid;
    }

    public function setHolderid(?string $holderid): self
    {
        $this->holderid = $holderid;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response): self
    {
        $this->response = $response;

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

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;

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

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getPaymentCommision(): ?float
    {
        return $this->paymentCommision;
    }

    public function setPaymentCommision(?float $paymentCommision): self
    {
        $this->paymentCommision = $paymentCommision;

        return $this;
    }

    public function getPaymentType(): ?PaymentType
    {
        return $this->paymentType;
    }

    public function setPaymentType(?PaymentType $paymentType): self
    {
        $this->paymentType = $paymentType;

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
