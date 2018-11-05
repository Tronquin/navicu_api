<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table(name="restaurant", indexes={@ORM\Index(name="idx_eb95123f8ad350ab", columns={"food_type_id"}), @ORM\Index(name="idx_eb95123fed5ca9e6", columns={"service_id"})})
 * @ORM\Entity
 */
class Restaurant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="restaurant_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var array|null
     *
     * @ORM\Column(name="breakfast_time", type="json_array", nullable=true)
     */
    private $breakfastTime;

    /**
     * @var array|null
     *
     * @ORM\Column(name="lunch_time", type="json_array", nullable=true)
     */
    private $lunchTime;

    /**
     * @var array|null
     *
     * @ORM\Column(name="dinner_time", type="json_array", nullable=true)
     */
    private $dinnerTime;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="dietary_menu", type="boolean", nullable=true)
     */
    private $dietaryMenu;

    /**
     * @var int|null
     *
     * @ORM\Column(name="buffet_carta", type="integer", nullable=true)
     */
    private $buffetCarta;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
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

    public function getBreakfastTime()
    {
        return $this->breakfastTime;
    }

    public function setBreakfastTime($breakfastTime): self
    {
        $this->breakfastTime = $breakfastTime;

        return $this;
    }

    public function getLunchTime()
    {
        return $this->lunchTime;
    }

    public function setLunchTime($lunchTime): self
    {
        $this->lunchTime = $lunchTime;

        return $this;
    }

    public function getDinnerTime()
    {
        return $this->dinnerTime;
    }

    public function setDinnerTime($dinnerTime): self
    {
        $this->dinnerTime = $dinnerTime;

        return $this;
    }

    public function getDietaryMenu(): ?bool
    {
        return $this->dietaryMenu;
    }

    public function setDietaryMenu(?bool $dietaryMenu): self
    {
        $this->dietaryMenu = $dietaryMenu;

        return $this;
    }

    public function getBuffetCarta(): ?int
    {
        return $this->buffetCarta;
    }

    public function setBuffetCarta(?int $buffetCarta): self
    {
        $this->buffetCarta = $buffetCarta;

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
