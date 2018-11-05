<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AirlineNationalBank
 *
 * @ORM\Table(name="airline_national_bank", indexes={@ORM\Index(name="idx_e571bd06b8c9803", columns={"airline_bank_id"})})
 * @ORM\Entity
 */
class AirlineNationalBank
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="airline_national_bank_id_seq", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="account", type="string", length=255, nullable=false)
     */
    private $account;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var \AirlineBank
     *
     * @ORM\ManyToOne(targetEntity="AirlineBank")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_bank_id", referencedColumnName="id")
     * })
     */
    private $airlineBank;

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

    public function getAccount(): ?string
    {
        return $this->account;
    }

    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAirlineBank(): ?AirlineBank
    {
        return $this->airlineBank;
    }

    public function setAirlineBank(?AirlineBank $airlineBank): self
    {
        $this->airlineBank = $airlineBank;

        return $this;
    }


}
