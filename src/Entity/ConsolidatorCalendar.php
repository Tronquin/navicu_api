<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsolidatorCalendar
 *
 * @ORM\Table(name="consolidator_calendar", indexes={@ORM\Index(name="idx_3f577c54aba811d9", columns={"consolidator_id"})})
 * @ORM\Entity
 */
class ConsolidatorCalendar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="consolidator_calendar_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="integer", nullable=false)
     */
    private $day;

    /**
     * @var \Consolidator
     *
     * @ORM\ManyToOne(targetEntity="Consolidator")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="consolidator_id", referencedColumnName="id")
     * })
     */
    private $consolidator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getConsolidator(): ?Consolidator
    {
        return $this->consolidator;
    }

    public function setConsolidator(?Consolidator $consolidator): self
    {
        $this->consolidator = $consolidator;

        return $this;
    }


}
