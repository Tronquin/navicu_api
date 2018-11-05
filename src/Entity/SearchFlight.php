<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SearchFlight
 *
 * @ORM\Table(name="search_flight", indexes={@ORM\Index(name="idx_1bb58911c52e520d", columns={"fromairport"}), @ORM\Index(name="idx_1bb589116ecd2540", columns={"toairport"})})
 * @ORM\Entity
 */
class SearchFlight
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="search_flight_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure", type="datetime", nullable=false)
     */
    private $departure;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="return", type="datetime", nullable=true)
     */
    private $return;

    /**
     * @var int
     *
     * @ORM\Column(name="adults", type="integer", nullable=false)
     */
    private $adults;

    /**
     * @var int
     *
     * @ORM\Column(name="childs", type="integer", nullable=false)
     */
    private $childs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="toairport", referencedColumnName="id")
     * })
     */
    private $toairport;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fromairport", referencedColumnName="id")
     * })
     */
    private $fromairport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeparture(): ?\DateTimeInterface
    {
        return $this->departure;
    }

    public function setDeparture(\DateTimeInterface $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getReturn(): ?\DateTimeInterface
    {
        return $this->return;
    }

    public function setReturn(?\DateTimeInterface $return): self
    {
        $this->return = $return;

        return $this;
    }

    public function getAdults(): ?int
    {
        return $this->adults;
    }

    public function setAdults(int $adults): self
    {
        $this->adults = $adults;

        return $this;
    }

    public function getChilds(): ?int
    {
        return $this->childs;
    }

    public function setChilds(int $childs): self
    {
        $this->childs = $childs;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getToairport(): ?Airport
    {
        return $this->toairport;
    }

    public function setToairport(?Airport $toairport): self
    {
        $this->toairport = $toairport;

        return $this;
    }

    public function getFromairport(): ?Airport
    {
        return $this->fromairport;
    }

    public function setFromairport(?Airport $fromairport): self
    {
        $this->fromairport = $fromairport;

        return $this;
    }


}
