<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SearchFlightLock
 *
 * @ORM\Table(name="search_flight_lock", indexes={@ORM\Index(name="idx_7dd85bf7878f9b0e", columns={"lock"}), @ORM\Index(name="idx_7dd85bf77bf6cc4d", columns={"searchflight"})})
 * @ORM\Entity
 */
class SearchFlightLock
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="search_flight_lock_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var \SearchFlight
     *
     * @ORM\ManyToOne(targetEntity="SearchFlight")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="searchflight", referencedColumnName="id")
     * })
     */
    private $searchflight;

    /**
     * @var \FlightLock
     *
     * @ORM\ManyToOne(targetEntity="FlightLock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lock", referencedColumnName="id")
     * })
     */
    private $lock;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSearchflight(): ?SearchFlight
    {
        return $this->searchflight;
    }

    public function setSearchflight(?SearchFlight $searchflight): self
    {
        $this->searchflight = $searchflight;

        return $this;
    }

    public function getLock(): ?FlightLock
    {
        return $this->lock;
    }

    public function setLock(?FlightLock $lock): self
    {
        $this->lock = $lock;

        return $this;
    }


}
