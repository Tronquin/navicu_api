<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirlineBank
 *
 * @ORM\Table(name="airline_bank", indexes={@ORM\Index(name="idx_a423431d130d0c16", columns={"airline_id"}), @ORM\Index(name="idx_a423431d38248176", columns={"currency_id"})})
 * @ORM\Entity
 */
class AirlineBank
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airline_bank_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float|null
     *
     * @ORM\Column(name="initialpayment", type="float", precision=10, scale=0, nullable=true)
     */
    private $initialpayment;

    /**
     * @var float|null
     *
     * @ORM\Column(name="availablepayment", type="float", precision=10, scale=0, nullable=true)
     */
    private $availablepayment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_account", type="string", length=50, nullable=true)
     */
    private $typeAccount;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_id", referencedColumnName="id")
     * })
     */
    private $airline;

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

    public function getInitialpayment(): ?float
    {
        return $this->initialpayment;
    }

    public function setInitialpayment(?float $initialpayment): self
    {
        $this->initialpayment = $initialpayment;

        return $this;
    }

    public function getAvailablepayment(): ?float
    {
        return $this->availablepayment;
    }

    public function setAvailablepayment(?float $availablepayment): self
    {
        $this->availablepayment = $availablepayment;

        return $this;
    }

    public function getTypeAccount(): ?string
    {
        return $this->typeAccount;
    }

    public function setTypeAccount(?string $typeAccount): self
    {
        $this->typeAccount = $typeAccount;

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
