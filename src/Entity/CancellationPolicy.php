<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CancellationPolicy
 *
 * @ORM\Table(name="cancellation_policy", indexes={@ORM\Index(name="idx_79bc54d4c54c8c93", columns={"type_id"})})
 * @ORM\Entity
 */
class CancellationPolicy
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cancellation_policy_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="variation_type", type="integer", nullable=false)
     */
    private $variationType;

    /**
     * @var float
     *
     * @ORM\Column(name="variation_amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $variationAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="variation_type_rule", type="integer", nullable=false)
     */
    private $variationTypeRule;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVariationType(): ?int
    {
        return $this->variationType;
    }

    public function setVariationType(int $variationType): self
    {
        $this->variationType = $variationType;

        return $this;
    }

    public function getVariationAmount(): ?float
    {
        return $this->variationAmount;
    }

    public function setVariationAmount(float $variationAmount): self
    {
        $this->variationAmount = $variationAmount;

        return $this;
    }

    public function getVariationTypeRule(): ?int
    {
        return $this->variationTypeRule;
    }

    public function setVariationTypeRule(int $variationTypeRule): self
    {
        $this->variationTypeRule = $variationTypeRule;

        return $this;
    }

    public function getType(): ?Categories
    {
        return $this->type;
    }

    public function setType(?Categories $type): self
    {
        $this->type = $type;

        return $this;
    }


}
