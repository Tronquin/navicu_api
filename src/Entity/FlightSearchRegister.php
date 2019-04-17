<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlightSearchRegisterRepository")
 */
class FlightSearchRegister
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $adults;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $children;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $baby;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $provider;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cabin;

    /**
     * @ORM\Column(type="integer")
     */
    private $scale;

    /**
     * @ORM\Column(type="integer")
     */
    private $baggage;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $searchType;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userCurrency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sourceSearchType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destSearchType;

    /**
     * @ORM\Column(type="integer")
     */
    private $roundTrip;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $itinerary = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dest;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $starDate;

    /**
     * @ORM\Column(type="json")
     */
    private $response = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdults(): ?int
    {
        return $this->adults;
    }

    public function setAdults(string $adults): self
    {
        $this->adults = $adults;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(?int $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getBaby(): ?int
    {
        return $this->baby;
    }

    public function setBaby(?int $baby): self
    {
        $this->baby = $baby;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCabin(): ?string
    {
        return $this->cabin;
    }

    public function setCabin(string $cabin): self
    {
        $this->cabin = $cabin;

        return $this;
    }

    public function getScale(): ?int
    {
        return $this->scale;
    }

    public function setScale(int $scale): self
    {
        $this->scale = $scale;

        return $this;
    }

    public function getBaggage(): ?int
    {
        return $this->baggage;
    }

    public function setBaggage(int $baggage): self
    {
        $this->baggage = $baggage;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getSearchType(): ?string
    {
        return $this->searchType;
    }

    public function setSearchType(string $searchType): self
    {
        $this->searchType = $searchType;

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

    public function getUserCurrency(): ?string
    {
        return $this->userCurrency;
    }

    public function setUserCurrency(string $userCurrency): self
    {
        $this->userCurrency = $userCurrency;

        return $this;
    }

    public function getSourceSearchType(): ?string
    {
        return $this->sourceSearchType;
    }

    public function setSourceSearchType(string $sourceSearchType): self
    {
        $this->sourceSearchType = $sourceSearchType;

        return $this;
    }

    public function getDestSearchType(): ?string
    {
        return $this->destSearchType;
    }

    public function setDestSearchType(string $destSearchType): self
    {
        $this->destSearchType = $destSearchType;

        return $this;
    }

    public function getRoundTrip(): ?int
    {
        return $this->roundTrip;
    }

    public function setRoundTrip(int $roundTrip): self
    {
        $this->roundTrip = $roundTrip;

        return $this;
    }

    public function getItinerary(): ?array
    {
        return $this->itinerary;
    }

    public function setItinerary(?array $itinerary): self
    {
        $this->itinerary = $itinerary;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getDest(): ?string
    {
        return $this->dest;
    }

    public function setDest(?string $dest): self
    {
        $this->dest = $dest;

        return $this;
    }

    public function getStarDate(): ?\DateTimeInterface
    {
        return $this->starDate;
    }

    public function setStarDate(?\DateTimeInterface $starDate): self
    {
        $this->starDate = $starDate;

        return $this;
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }

    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }
}
