<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\PublicId;
use Doctrine\ORM\Mapping as ORM;

/**
 * FlightReservation
 *
 * @ORM\Table(name="flight_reservation", indexes={@ORM\Index(name="IDX_F73DF7AE18E5767C", columns={"currency_type_id"}), @ORM\Index(name="IDX_F73DF7AE7E6A667", columns={"flight_type_schedule_id"}), @ORM\Index(name="IDX_F73DF7AEF3EFD182", columns={"flight_class_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FlightReservationRepository"))
 */
class FlightReservation
{
    /** Flight reservation states */
    const STATE_IN_PROCESS = 1;
    const STATE_ACCEPTED = 2;
    const STATE_CANCEL = 3;

    /** Flight shedule */
    const ONE_WAY = 1;
    const ROUND_TRIP = 2;
    const MULTIPLE = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_reservation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reservation_date", type="datetime", nullable=false)
     */
    private $reservationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=false)
     */
    private $publicId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="child_number", type="integer", nullable=true)
     */
    private $childNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="adult_number", type="integer", nullable=true)
     */
    private $adultNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="inf_number", type="integer", nullable=true)
     */
    private $infNumber;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ins_number", type="integer", nullable=true)
     */
    private $insNumber;

   
    /**
     * @var int|null
     *
     * @ORM\Column(name="confirmation_status", type="integer", nullable=true)
     */
    private $confirmationStatus;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmation_log", type="text", nullable=true)
     */
    private $confirmationLog;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true, options={"default"="WEB"})
     */
    private $type = 'WEB';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_address", type="string", length=16, nullable=true)
     */
    private $ipAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="expire_date", type="datetime", nullable=false)
     */
    private $expire_date;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;


    /**
     * @var \FlightTypeSchedule
     *
     * @ORM\ManyToOne(targetEntity="FlightTypeSchedule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_type_schedule_id", referencedColumnName="id")
     * })
     */
    private $flightTypeSchedule;

    /**
     * @var \FlightCabin
     *
     * @ORM\ManyToOne(targetEntity="FlightCabin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_cabin_id", referencedColumnName="id")
     * })
     */
    private $flightCabin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="FlightReservationGds", mappedBy="flightReservation") 
     */
    private $gdsReservations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="FlightPayment", mappedBy="flightReservation",cascade={"persist"})
     */
    private $payments;

    public function __construct()
    {
        $this->gdsReservations = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $publicId = new PublicId('dateHex');
        $this->publicId = $publicId->toString();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getPublicId(): ?string
    {        
        return $this->publicId;
    }

    public function setPublicId($public_id): self
    {
        $this->publicId = $public_id;

        return $this;
    }

    public function getChildNumber(): ?int
    {
        return $this->childNumber;
    }

    public function setChildNumber(?int $childNumber): self
    {
        $this->childNumber = $childNumber;

        return $this;
    }

    public function getAdultNumber(): ?int
    {
        return $this->adultNumber;
    }

    public function setAdultNumber(?int $adultNumber): self
    {
        $this->adultNumber = $adultNumber;

        return $this;
    }

    public function getInfNumber(): ?int
    {
        return $this->infNumber;
    }

    public function setInfNumber(?int $infNumber): self
    {
        $this->infNumber = $infNumber;

        return $this;
    }

    public function getInsNumber(): ?int
    {
        return $this->insNumber;
    }

    public function setInsNumber(?int $insNumber): self
    {
        $this->insNumber = $insNumber;

        return $this;
    }

    
    public function getConfirmationStatus(): ?int
    {
        return $this->confirmationStatus;
    }

    public function setConfirmationStatus(?int $confirmationStatus): self
    {
        $this->confirmationStatus = $confirmationStatus;

        return $this;
    }

    public function getConfirmationLog(): ?string
    {
        return $this->confirmationLog;
    }

    public function setConfirmationLog(?string $confirmationLog): self
    {
        $this->confirmationLog = $confirmationLog;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set expire_date
     *
     * @param \DateTime $expireDate
     * @return FlightReservation
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;

        return $this;
    }

    /**
     * Get expire_date
     *
     * @return \DateTime 
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }
    

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

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

    public function getFlightTypeSchedule(): ?FlightTypeSchedule
    {
        return $this->flightTypeSchedule;
    }

    public function setFlightTypeSchedule(?FlightTypeSchedule $flightTypeSchedule): self
    {
        $this->flightTypeSchedule = $flightTypeSchedule;

        return $this;
    }

    public function getFlightCabin(): ?FlightCabin
    {
        return $this->flightCabin;
    }

    public function setFlightCabin(?FlightCabin $flightCabin): self
    {
        $this->flightCabin= $flightCabin;

        return $this;
    }

    /**
     * Add FlightReservationGds
     *   
     */
    public function addFlightReservationGds(FlightReservationGds $flightReservationGds)
    {
        $this->gdsReservations[] = $flightReservationGds;

        $flightReservationGds->setReservation($this);

        return $this;
    }

    public function removeFlightReservationGds(FlightReservationGds $flightReservationGds)
    {
        $this->gdsReservation->removeElement($flightReservationGds);
    }

    /**
     * @return Collection|FlightReservationGds[]
     */
    public function getGdsReservations(): Collection
    {
        return $this->gdsReservations;
    }

    public function addGdsReservation(FlightReservationGds $gdsReservation): self
    {
        if (!$this->gdsReservations->contains($gdsReservation)) {
            $this->gdsReservations[] = $gdsReservation;
            $gdsReservation->setFlightReservation($this);
        }

        return $this;
    }

    public function removeGdsReservation(FlightReservationGds $gdsReservation): self
    {
        if ($this->gdsReservations->contains($gdsReservation)) {
            $this->gdsReservations->removeElement($gdsReservation);
            // set the owning side to null (unless already changed)
            if ($gdsReservation->getFlightReservation() === $this) {
                $gdsReservation->setFlightReservation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FlightPayment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(FlightPayment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setFlightReservation($this);
        }

        return $this;
    }

    public function removePayment(FlightPayment $payment): self
    {
        if ($this->payments->contains($payment)) {
            $this->payments->removeElement($payment);
            // set the owning side to null (unless already changed)
            if ($payment->getFlightReservation() === $this) {
                $payment->setFlightReservation(null);
            }
        }

        return $this;
    }

    

}
