<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bar
 *
 * @ORM\Table(name="bar", indexes={@ORM\Index(name="idx_76ff8caa8ad350ab", columns={"food_type_id"}), @ORM\Index(name="idx_76ff8caaed5ca9e6", columns={"service_id"})})
 * @ORM\Entity
 */
class Bar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bar_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="min_age", type="integer", nullable=false)
     */
    private $minAge;

    /**
     * @var bool
     *
     * @ORM\Column(name="food", type="boolean", nullable=false)
     */
    private $food;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var array
     *
     * @ORM\Column(name="schedule", type="json_array", nullable=false)
     */
    private $schedule;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var \FoodType
     *
     * @ORM\ManyToOne(targetEntity="FoodType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="food_type_id", referencedColumnName="id")
     * })
     */
    private $foodType;

    /**
     * @var \PropertyService
     *
     * @ORM\ManyToOne(targetEntity="PropertyService")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * })
     */
    private $service;

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

    public function getMinAge(): ?int
    {
        return $this->minAge;
    }

    public function setMinAge(int $minAge): self
    {
        $this->minAge = $minAge;

        return $this;
    }

    public function getFood(): ?bool
    {
        return $this->food;
    }

    public function setFood(bool $food): self
    {
        $this->food = $food;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFoodType(): ?FoodType
    {
        return $this->foodType;
    }

    public function setFoodType(?FoodType $foodType): self
    {
        $this->foodType = $foodType;

        return $this;
    }

    public function getService(): ?PropertyService
    {
        return $this->service;
    }

    public function setService(?PropertyService $service): self
    {
        $this->service = $service;

        return $this;
    }


}
