<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consolidator
 *
 * @ORM\Table(name="consolidator")
 * @ORM\Entity
 */
class Consolidator
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="consolidator_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="credit", type="float", precision=10, scale=0, nullable=false)
     */
    private $credit;

    /**
     * @var float
     *
     * @ORM\Column(name="credit_available", type="float", precision=10, scale=0, nullable=false)
     */
    private $creditAvailable;

    /**
     * @var float
     *
     * @ORM\Column(name="credit_warning", type="float", precision=10, scale=0, nullable=false)
     */
    private $creditWarning;

    /**
     * @var int
     *
     * @ORM\Column(name="credit_frequency", type="integer", nullable=false)
     */
    private $creditFrequency;

    /**
     * @var string
     *
     * @ORM\Column(name="office_id", type="string", length=20, nullable=false)
     */
    private $officeId;

    /**
     * @var float
     *
     * @ORM\Column(name="increment", type="float", precision=10, scale=0, nullable=false)
     */
    private $increment;

    /**
     * @var int
     *
     * @ORM\Column(name="increment_type", type="integer", nullable=false)
     */
    private $incrementType;

    /**
     * @var int
     *
     * @ORM\Column(name="currency", type="integer", nullable=false)
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="increment_tarifa_neg", type="float", precision=10, scale=0, nullable=false)
     */
    private $incrementTarifaNeg;

    /**
     * @var int
     *
     * @ORM\Column(name="increment_type_tarifa_neg", type="integer", nullable=false)
     */
    private $incrementTypeTarifaNeg;

    /**
     * @var string
     *
     * @ORM\Column(name="email_contact", type="string", length=255, nullable=false)
     */
    private $emailContact;

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

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(float $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getCreditAvailable(): ?float
    {
        return $this->creditAvailable;
    }

    public function setCreditAvailable(float $creditAvailable): self
    {
        $this->creditAvailable = $creditAvailable;

        return $this;
    }

    public function getCreditWarning(): ?float
    {
        return $this->creditWarning;
    }

    public function setCreditWarning(float $creditWarning): self
    {
        $this->creditWarning = $creditWarning;

        return $this;
    }

    public function getCreditFrequency(): ?int
    {
        return $this->creditFrequency;
    }

    public function setCreditFrequency(int $creditFrequency): self
    {
        $this->creditFrequency = $creditFrequency;

        return $this;
    }

    public function getOfficeId(): ?string
    {
        return $this->officeId;
    }

    public function setOfficeId(string $officeId): self
    {
        $this->officeId = $officeId;

        return $this;
    }

    public function getIncrement(): ?float
    {
        return $this->increment;
    }

    public function setIncrement(float $increment): self
    {
        $this->increment = $increment;

        return $this;
    }

    public function getIncrementType(): ?int
    {
        return $this->incrementType;
    }

    public function setIncrementType(int $incrementType): self
    {
        $this->incrementType = $incrementType;

        return $this;
    }

    public function getCurrency(): ?int
    {
        return $this->currency;
    }

    public function setCurrency(int $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getIncrementTarifaNeg(): ?float
    {
        return $this->incrementTarifaNeg;
    }

    public function setIncrementTarifaNeg(float $incrementTarifaNeg): self
    {
        $this->incrementTarifaNeg = $incrementTarifaNeg;

        return $this;
    }

    public function getIncrementTypeTarifaNeg(): ?int
    {
        return $this->incrementTypeTarifaNeg;
    }

    public function setIncrementTypeTarifaNeg(int $incrementTypeTarifaNeg): self
    {
        $this->incrementTypeTarifaNeg = $incrementTypeTarifaNeg;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }


}
