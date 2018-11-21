<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightGeneralConditions
 *
 * @ORM\Table(name="flight_general_conditions")
 * @ORM\Entity
 */
class FlightGeneralConditions
{    

    const INCREMENT_TYPE_PERCENTAGE = 0;
    const INCREMENT_TYPE_LOCAL = 1;
    const INCREMENT_TYPE_USD = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_general_conditions_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expense_type", type="integer", nullable=true)
     */
    private $expenseType;

    /**
     * @var float|null
     *
     * @ORM\Column(name="expense_value", type="float", precision=10, scale=0, nullable=true)
     */
    private $expenseValue;

    /**
     * @var int|null
     *
     * @ORM\Column(name="guarantee_type", type="integer", nullable=true)
     */
    private $guaranteeType;

    /**
     * @var float|null
     *
     * @ORM\Column(name="guarantee_value", type="float", precision=10, scale=0, nullable=true)
     */
    private $guaranteeValue;

    /**
     * @var int|null
     *
     * @ORM\Column(name="discount_type", type="integer", nullable=true)
     */
    private $discountType;

    /**
     * @var float|null
     *
     * @ORM\Column(name="discount_value", type="float", precision=10, scale=0, nullable=true)
     */
    private $discountValue;

    /**
     * @var float|null
     *
     * @ORM\Column(name="markup", type="float", precision=10, scale=0, nullable=true)
     */
    private $markup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenseType(): ?int
    {
        return $this->expenseType;
    }

    public function setExpenseType(?int $expenseType): self
    {
        $this->expenseType = $expenseType;

        return $this;
    }

    public function getExpenseValue(): ?float
    {
        return $this->expenseValue;
    }

    public function setExpenseValue(?float $expenseValue): self
    {
        $this->expenseValue = $expenseValue;

        return $this;
    }

    public function getGuaranteeType(): ?int
    {
        return $this->guaranteeType;
    }

    public function setGuaranteeType(?int $guaranteeType): self
    {
        $this->guaranteeType = $guaranteeType;

        return $this;
    }

    public function getGuaranteeValue(): ?float
    {
        return $this->guaranteeValue;
    }

    public function setGuaranteeValue(?float $guaranteeValue): self
    {
        $this->guaranteeValue = $guaranteeValue;

        return $this;
    }

    public function getDiscountType(): ?int
    {
        return $this->discountType;
    }

    public function setDiscountType(?int $discountType): self
    {
        $this->discountType = $discountType;

        return $this;
    }

    public function getDiscountValue(): ?float
    {
        return $this->discountValue;
    }

    public function setDiscountValue(?float $discountValue): self
    {
        $this->discountValue = $discountValue;

        return $this;
    }

    public function getMarkup(): ?float
    {
        return $this->markup;
    }

    public function setMarkup(?float $markup): self
    {
        $this->markup = $markup;

        return $this;
    }


}
