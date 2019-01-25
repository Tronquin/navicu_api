<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyService
 *
 * @ORM\Table(name="property_service", indexes={@ORM\Index(name="idx_b850d0aac54c8c93", columns={"type_id"}), @ORM\Index(name="idx_b850d0aa549213ec", columns={"property_id"})})
 * @ORM\Entity
 */
class PropertyService
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_service_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float|null
     *
     * @ORM\Column(name="cost_service", type="float", precision=10, scale=0, nullable=true)
     */
    private $costService;

    /**
     * @var bool
     *
     * @ORM\Column(name="free", type="boolean", nullable=false)
     */
    private $free;

    /**
     * @var array|null
     *
     * @ORM\Column(name="schedule", type="json_array", nullable=true)
     */
    private $schedule;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @var \ServiceType
     *
     * @ORM\ManyToOne(targetEntity="ServiceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCostService(): ?float
    {
        return $this->costService;
    }

    public function setCostService(?float $costService): self
    {
        $this->costService = $costService;

        return $this;
    }

    public function getFree(): ?bool
    {
        return $this->free;
    }

    public function setFree(bool $free): self
    {
        $this->free = $free;

        return $this;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    public function setSchedule($schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getType(): ?ServiceType
    {
        return $this->type;
    }

    public function setType(?ServiceType $type): self
    {
        $this->type = $type;

        return $this;
    }


}
