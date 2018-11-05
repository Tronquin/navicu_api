<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsolidatorTransaction
 *
 * @ORM\Table(name="consolidator_transaction", indexes={@ORM\Index(name="idx_30616d7aba811d9", columns={"consolidator_id"})})
 * @ORM\Entity
 */
class ConsolidatorTransaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="consolidator_transaction_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="currency", type="integer", nullable=false)
     */
    private $currency;

    /**
     * @var \Consolidator
     *
     * @ORM\ManyToOne(targetEntity="Consolidator")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="consolidator_id", referencedColumnName="id")
     * })
     */
    private $consolidator;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCurrency(): ?int
    {
        return $this->currency;
    }

    public function setCurrency(int $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getConsolidator(): ?Consolidator
    {
        return $this->consolidator;
    }

    public function setConsolidator(?Consolidator $consolidator): self
    {
        $this->consolidator = $consolidator;

        return $this;
    }


}
