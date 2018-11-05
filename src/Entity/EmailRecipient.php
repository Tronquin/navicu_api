<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailRecipient
 *
 * @ORM\Table(name="email_recipient")
 * @ORM\Entity
 */
class EmailRecipient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="email_recipient_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservation_aavv_client", type="boolean", nullable=false)
     */
    private $reservationAavvClient = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservation_aavv", type="boolean", nullable=false)
     */
    private $reservationAavv = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservation_status_change", type="boolean", nullable=false)
     */
    private $reservationStatusChange = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservation_process", type="boolean", nullable=false)
     */
    private $reservationProcess = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservation_denied", type="boolean", nullable=false)
     */
    private $reservationDenied = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="unsold_flight_lock", type="boolean", nullable=false)
     */
    private $unsoldFlightLock = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="flight_lock", type="boolean", nullable=false)
     */
    private $flightLock = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="flight_resume", type="boolean", nullable=false)
     */
    private $flightResume = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="pre_reservation", type="boolean", nullable=false)
     */
    private $preReservation = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="temp_property", type="boolean", nullable=false)
     */
    private $tempProperty = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aavv_preregister", type="boolean", nullable=false)
     */
    private $aavvPreregister = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="aavv_register", type="boolean", nullable=false)
     */
    private $aavvRegister = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="properties_without_fees", type="boolean", nullable=false)
     */
    private $propertiesWithoutFees = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="reservation_expiration", type="boolean", nullable=false)
     */
    private $reservationExpiration = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="consolidator_daily_report", type="boolean", nullable=false)
     */
    private $consolidatorDailyReport = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="consolidator_period_report", type="boolean", nullable=false)
     */
    private $consolidatorPeriodReport = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="consolidator_balance_notification", type="boolean", nullable=false)
     */
    private $consolidatorBalanceNotification = false;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getReservationAavvClient(): ?bool
    {
        return $this->reservationAavvClient;
    }

    public function setReservationAavvClient(bool $reservationAavvClient): self
    {
        $this->reservationAavvClient = $reservationAavvClient;

        return $this;
    }

    public function getReservationAavv(): ?bool
    {
        return $this->reservationAavv;
    }

    public function setReservationAavv(bool $reservationAavv): self
    {
        $this->reservationAavv = $reservationAavv;

        return $this;
    }

    public function getReservationStatusChange(): ?bool
    {
        return $this->reservationStatusChange;
    }

    public function setReservationStatusChange(bool $reservationStatusChange): self
    {
        $this->reservationStatusChange = $reservationStatusChange;

        return $this;
    }

    public function getReservationProcess(): ?bool
    {
        return $this->reservationProcess;
    }

    public function setReservationProcess(bool $reservationProcess): self
    {
        $this->reservationProcess = $reservationProcess;

        return $this;
    }

    public function getReservationDenied(): ?bool
    {
        return $this->reservationDenied;
    }

    public function setReservationDenied(bool $reservationDenied): self
    {
        $this->reservationDenied = $reservationDenied;

        return $this;
    }

    public function getUnsoldFlightLock(): ?bool
    {
        return $this->unsoldFlightLock;
    }

    public function setUnsoldFlightLock(bool $unsoldFlightLock): self
    {
        $this->unsoldFlightLock = $unsoldFlightLock;

        return $this;
    }

    public function getFlightLock(): ?bool
    {
        return $this->flightLock;
    }

    public function setFlightLock(bool $flightLock): self
    {
        $this->flightLock = $flightLock;

        return $this;
    }

    public function getFlightResume(): ?bool
    {
        return $this->flightResume;
    }

    public function setFlightResume(bool $flightResume): self
    {
        $this->flightResume = $flightResume;

        return $this;
    }

    public function getPreReservation(): ?bool
    {
        return $this->preReservation;
    }

    public function setPreReservation(bool $preReservation): self
    {
        $this->preReservation = $preReservation;

        return $this;
    }

    public function getTempProperty(): ?bool
    {
        return $this->tempProperty;
    }

    public function setTempProperty(bool $tempProperty): self
    {
        $this->tempProperty = $tempProperty;

        return $this;
    }

    public function getAavvPreregister(): ?bool
    {
        return $this->aavvPreregister;
    }

    public function setAavvPreregister(bool $aavvPreregister): self
    {
        $this->aavvPreregister = $aavvPreregister;

        return $this;
    }

    public function getAavvRegister(): ?bool
    {
        return $this->aavvRegister;
    }

    public function setAavvRegister(bool $aavvRegister): self
    {
        $this->aavvRegister = $aavvRegister;

        return $this;
    }

    public function getPropertiesWithoutFees(): ?bool
    {
        return $this->propertiesWithoutFees;
    }

    public function setPropertiesWithoutFees(bool $propertiesWithoutFees): self
    {
        $this->propertiesWithoutFees = $propertiesWithoutFees;

        return $this;
    }

    public function getReservationExpiration(): ?bool
    {
        return $this->reservationExpiration;
    }

    public function setReservationExpiration(bool $reservationExpiration): self
    {
        $this->reservationExpiration = $reservationExpiration;

        return $this;
    }

    public function getConsolidatorDailyReport(): ?bool
    {
        return $this->consolidatorDailyReport;
    }

    public function setConsolidatorDailyReport(bool $consolidatorDailyReport): self
    {
        $this->consolidatorDailyReport = $consolidatorDailyReport;

        return $this;
    }

    public function getConsolidatorPeriodReport(): ?bool
    {
        return $this->consolidatorPeriodReport;
    }

    public function setConsolidatorPeriodReport(bool $consolidatorPeriodReport): self
    {
        $this->consolidatorPeriodReport = $consolidatorPeriodReport;

        return $this;
    }

    public function getConsolidatorBalanceNotification(): ?bool
    {
        return $this->consolidatorBalanceNotification;
    }

    public function setConsolidatorBalanceNotification(bool $consolidatorBalanceNotification): self
    {
        $this->consolidatorBalanceNotification = $consolidatorBalanceNotification;

        return $this;
    }


}
