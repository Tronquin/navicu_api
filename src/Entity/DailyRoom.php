<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyRoom
 *
 * @ORM\Table(name="daily_room", indexes={@ORM\Index(name="idx_36994e0e54177093", columns={"room_id"})})
 * @ORM\Entity
 */
class DailyRoom
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="daily_room_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_completed", type="boolean", nullable=false)
     */
    private $isCompleted;

    /**
     * @var int|null
     *
     * @ORM\Column(name="availability", type="integer", nullable=true)
     */
    private $availability;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cut_off", type="integer", nullable=true)
     */
    private $cutOff;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="stop_sell", type="boolean", nullable=true)
     */
    private $stopSell;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min_night", type="integer", nullable=true)
     */
    private $minNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_night", type="integer", nullable=true)
     */
    private $maxNight;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_modified", type="datetime", nullable=true)
     */
    private $lastModified;

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

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

    public function getIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getAvailability(): ?int
    {
        return $this->availability;
    }

    public function setAvailability(?int $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getCutOff(): ?int
    {
        return $this->cutOff;
    }

    public function setCutOff(?int $cutOff): self
    {
        $this->cutOff = $cutOff;

        return $this;
    }

    public function getStopSell(): ?bool
    {
        return $this->stopSell;
    }

    public function setStopSell(?bool $stopSell): self
    {
        $this->stopSell = $stopSell;

        return $this;
    }

    public function getMinNight(): ?int
    {
        return $this->minNight;
    }

    public function setMinNight(?int $minNight): self
    {
        $this->minNight = $minNight;

        return $this;
    }

    public function getMaxNight(): ?int
    {
        return $this->maxNight;
    }

    public function setMaxNight(?int $maxNight): self
    {
        $this->maxNight = $maxNight;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(?\DateTimeInterface $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }


}
