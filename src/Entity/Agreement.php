<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agreement
 *
 * @ORM\Table(name="agreement", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_2e655a24549213ec", columns={"property_id"}), @ORM\UniqueConstraint(name="uniq_2e655a24c33f7837", columns={"document_id"})})
 * @ORM\Entity
 */
class Agreement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="agreement_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="client_ip_address", type="string", length=15, nullable=false)
     */
    private $clientIpAddress;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="credit_days", type="integer", nullable=false, options={"default"="30"})
     */
    private $creditDays = '30';

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
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     * })
     */
    private $document;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientIpAddress(): ?string
    {
        return $this->clientIpAddress;
    }

    public function setClientIpAddress(string $clientIpAddress): self
    {
        $this->clientIpAddress = $clientIpAddress;

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

    public function getCreditDays(): ?int
    {
        return $this->creditDays;
    }

    public function setCreditDays(int $creditDays): self
    {
        $this->creditDays = $creditDays;

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

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }


}
