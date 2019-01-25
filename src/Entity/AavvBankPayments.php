<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AavvBankPayments
 *
 * @ORM\Table(name="aavv_bank_payments", indexes={@ORM\Index(name="idx_19e9414ed2c3b2dd", columns={"aavv_id"}), @ORM\Index(name="idx_19e9414e26be05a7", columns={"bank_type"})})
 * @ORM\Entity
 */
class AavvBankPayments
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_bank_payments_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="number_reference", type="string", length=255, nullable=true)
     */
    private $numberReference;

    /**
     * @var float|null
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby", type="integer", nullable=true)
     */
    private $createdby;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updatedby", type="integer", nullable=true)
     */
    private $updatedby;

    /**
     * @var \BankType
     *
     * @ORM\ManyToOne(targetEntity="BankType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bank_type", referencedColumnName="id")
     * })
     */
    private $bankType;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

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

    public function getNumberReference(): ?string
    {
        return $this->numberReference;
    }

    public function setNumberReference(?string $numberReference): self
    {
        $this->numberReference = $numberReference;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getCreatedby(): ?int
    {
        return $this->createdby;
    }

    public function setCreatedby(?int $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getUpdatedby(): ?int
    {
        return $this->updatedby;
    }

    public function setUpdatedby(?int $updatedby): self
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    public function getBankType(): ?BankType
    {
        return $this->bankType;
    }

    public function setBankType(?BankType $bankType): self
    {
        $this->bankType = $bankType;

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
