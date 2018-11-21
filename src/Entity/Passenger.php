<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Passenger
 *
 * @ORM\Table(name="passenger", indexes={@ORM\Index(name="idx_3befe8ddf73df7ae", columns={"flight_reservation"})})
 * @ORM\Entity
 */
class Passenger
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="passenger_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="document_type", type="string", length=255, nullable=false)
     */
    private $documentType;

    /**
     * @var string
     *
     * @ORM\Column(name="document_number", type="string", length=15, nullable=false)
     */
    private $documentNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var int|null
     *
     * @ORM\Column(name="padre_id", type="integer", nullable=true)
     */
    private $padreId;

    /**
     * @var \FlightReservation
     *
     * @ORM\ManyToOne(targetEntity="FlightReservation", inversedBy="passengers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flight_reservation", referencedColumnName="id")
     * })
     */
    private $flightReservation;


    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="FlightTicket", mappedBy="passenger") 
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }



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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    public function setDocumentType(string $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->documentNumber;
    }

    public function setDocumentNumber(string $documentNumber): self
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPadreId(): ?int
    {
        return $this->padreId;
    }

    public function setPadreId(?int $padreId): self
    {
        $this->padreId = $padreId;

        return $this;
    }

    public function getFlightReservation(): ?FlightReservation
    {
        return $this->flightReservation;
    }

    public function setFlightReservation(?FlightReservation $flightReservation): self
    {
        $this->flightReservation = $flightReservation;

        return $this;
    }

     /**
     * @return Collection|FlightTicket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(FlightTicket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setPassenger($this);
        }

        return $this;
    }

    public function removeTicket(FlightTicket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getPassenger() === $this) {
                $ticket->setPassenger(null);
            }
        }

        return $this;
    }


}
