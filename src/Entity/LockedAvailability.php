<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LockedAvailability
 *
 * @ORM\Table(name="locked_availability", indexes={@ORM\Index(name="idx_8d4cf87258af9a2e", columns={"dp_id"}), @ORM\Index(name="idx_8d4cf872f2a652a5", columns={"dr_id"}), @ORM\Index(name="idx_8d4cf872b83297e7", columns={"reservation_id"})})
 * @ORM\Entity
 */
class LockedAvailability
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="locked_availability_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_session", type="string", length=255, nullable=false)
     */
    private $idSession;

    /**
     * @var int
     *
     * @ORM\Column(name="number_packages", type="integer", nullable=false)
     */
    private $numberPackages;

    /**
     * @var int
     *
     * @ORM\Column(name="expiry", type="integer", nullable=false)
     */
    private $expiry;

    /**
     * @var \DailyPack
     *
     * @ORM\ManyToOne(targetEntity="DailyPack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dp_id", referencedColumnName="id")
     * })
     */
    private $dp;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     * })
     */
    private $reservation;

    /**
     * @var \DailyRoom
     *
     * @ORM\ManyToOne(targetEntity="DailyRoom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dr_id", referencedColumnName="id")
     * })
     */
    private $dr;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSession(): ?string
    {
        return $this->idSession;
    }

    public function setIdSession(string $idSession): self
    {
        $this->idSession = $idSession;

        return $this;
    }

    public function getNumberPackages(): ?int
    {
        return $this->numberPackages;
    }

    public function setNumberPackages(int $numberPackages): self
    {
        $this->numberPackages = $numberPackages;

        return $this;
    }

    public function getExpiry(): ?int
    {
        return $this->expiry;
    }

    public function setExpiry(int $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getDp(): ?DailyPack
    {
        return $this->dp;
    }

    public function setDp(?DailyPack $dp): self
    {
        $this->dp = $dp;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getDr(): ?DailyRoom
    {
        return $this->dr;
    }

    public function setDr(?DailyRoom $dr): self
    {
        $this->dr = $dr;

        return $this;
    }


}
