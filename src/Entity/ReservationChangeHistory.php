<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationChangeHistory
 *
 * @ORM\Table(name="reservation_change_history", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_c28993dba76ed395", columns={"user_id"}), @ORM\UniqueConstraint(name="uniq_c28993dbf107e7c6", columns={"last_status"})}, indexes={@ORM\Index(name="idx_c28993dbb83297e7", columns={"reservation_id"})})
 * @ORM\Entity
 */
class ReservationChangeHistory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="reservation_change_history_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var array|null
     *
     * @ORM\Column(name="data_log", type="json_array", nullable=true)
     */
    private $dataLog;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

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
     * @var \ReservationChangeHistory
     *
     * @ORM\ManyToOne(targetEntity="ReservationChangeHistory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="last_status", referencedColumnName="id")
     * })
     */
    private $lastStatus;

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

    public function getDataLog()
    {
        return $this->dataLog;
    }

    public function setDataLog($dataLog): self
    {
        $this->dataLog = $dataLog;

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

    public function getUser(): ?FosUser
    {
        return $this->user;
    }

    public function setUser(?FosUser $user): self
    {
        $this->user = $user;

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

    public function getLastStatus(): ?self
    {
        return $this->lastStatus;
    }

    public function setLastStatus(?self $lastStatus): self
    {
        $this->lastStatus = $lastStatus;

        return $this;
    }


}
