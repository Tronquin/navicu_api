<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExchangeRateHistory
 *
 * @ORM\Table(name="exchange_rate_history", indexes={@ORM\Index(name="idx_51c18a99669145d", columns={"currency_type"})})
 * @ORM\Entity
 */
class ExchangeRateHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="exchange_rate_history_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rate_api", type="float", precision=10, scale=0, nullable=true)
     */
    private $rateApi;

    /**
     * @var int|null
     *
     * @ORM\Column(name="percentage_navicu", type="integer", nullable=true)
     */
    private $percentageNavicu;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rate_navicu", type="float", precision=10, scale=0, nullable=true)
     */
    private $rateNavicu;

    /**
     * @var float|null
     *
     * @ORM\Column(name="dicom", type="float", precision=10, scale=0, nullable=true)
     */
    private $dicom;

    /**
     * @var float|null
     *
     * @ORM\Column(name="percentage_navicu_sell", type="float", precision=10, scale=0, nullable=true)
     */
    private $percentageNavicuSell;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rate_navicu_sell", type="float", precision=10, scale=0, nullable=true)
     */
    private $rateNavicuSell;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_type", referencedColumnName="id")
     * })
     */
    private $currencyType;

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

    public function getRateApi(): ?float
    {
        return $this->rateApi;
    }

    public function setRateApi(?float $rateApi): self
    {
        $this->rateApi = $rateApi;

        return $this;
    }

    public function getPercentageNavicu(): ?int
    {
        return $this->percentageNavicu;
    }

    public function setPercentageNavicu(?int $percentageNavicu): self
    {
        $this->percentageNavicu = $percentageNavicu;

        return $this;
    }

    public function getRateNavicu(): ?float
    {
        return $this->rateNavicu;
    }

    public function setRateNavicu(?float $rateNavicu): self
    {
        $this->rateNavicu = $rateNavicu;

        return $this;
    }

    public function getDicom(): ?float
    {
        return $this->dicom;
    }

    public function setDicom(?float $dicom): self
    {
        $this->dicom = $dicom;

        return $this;
    }

    public function getPercentageNavicuSell(): ?float
    {
        return $this->percentageNavicuSell;
    }

    public function setPercentageNavicuSell(?float $percentageNavicuSell): self
    {
        $this->percentageNavicuSell = $percentageNavicuSell;

        return $this;
    }

    public function getRateNavicuSell(): ?float
    {
        return $this->rateNavicuSell;
    }

    public function setRateNavicuSell(?float $rateNavicuSell): self
    {
        $this->rateNavicuSell = $rateNavicuSell;

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


}
