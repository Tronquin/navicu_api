<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExchangeRateHourly
 *
 * @ORM\Table(name="exchange_rate_hourly", indexes={@ORM\Index(name="IDX_2B98FEBB98CC4F9", columns={"exchange_rate_history_id"})})
 * @ORM\Entity
 */
class ExchangeRateHourly
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="exchange_rate_hourly_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time", nullable=false)
     */
    private $time;

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
     * @var int|null
     *
     * @ORM\Column(name="percentage_navicu_sell", type="integer", nullable=true)
     */
    private $percentageNavicuSell;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rate_navicu_sell", type="float", precision=10, scale=0, nullable=true)
     */
    private $rateNavicuSell;

    /**
     * @var \ExchangeRateHistory
     *
     * @ORM\ManyToOne(targetEntity="ExchangeRateHistory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="exchange_rate_history_id", referencedColumnName="id")
     * })
     */
    private $exchangeRateHistory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

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

    public function getPercentageNavicuSell(): ?int
    {
        return $this->percentageNavicuSell;
    }

    public function setPercentageNavicuSell(?int $percentageNavicuSell): self
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

    public function getExchangeRateHistory(): ?ExchangeRateHistory
    {
        return $this->exchangeRateHistory;
    }

    public function setExchangeRateHistory(?ExchangeRateHistory $exchangeRateHistory): self
    {
        $this->exchangeRateHistory = $exchangeRateHistory;

        return $this;
    }


}
