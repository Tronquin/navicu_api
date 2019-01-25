<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AavvAgreement
 *
 * @ORM\Table(name="aavv_agreement", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_4e9f3ba8c33f7837", columns={"document_id"}), @ORM\UniqueConstraint(name="uniq_4e9f3ba8d2c3b2dd", columns={"aavv_id"})})
 * @ORM\Entity
 */
class AavvAgreement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_agreement_id_seq", allocationSize=1, initialValue=1)
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
     * @var float
     *
     * @ORM\Column(name="discount_rate", type="float", precision=10, scale=0, nullable=false, options={"default"="0.100000000000000006"})
     */
    private $discountRate = '0.100000000000000006';

    /**
     * @var \Document
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     * })
     */
    private $document;

    /**
     * @var \Aavv
     *
     * @ORM\ManyToOne(targetEntity="Aavv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_id", referencedColumnName="id")
     * })
     */
    private $aavv;

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

    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(float $discountRate): self
    {
        $this->discountRate = $discountRate;

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

    public function getAavv(): ?Aavv
    {
        return $this->aavv;
    }

    public function setAavv(?Aavv $aavv): self
    {
        $this->aavv = $aavv;

        return $this;
    }


}
