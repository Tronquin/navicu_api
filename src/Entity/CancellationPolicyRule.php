<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CancellationPolicyRule
 *
 * @ORM\Table(name="cancellation_policy_rule", indexes={@ORM\Index(name="idx_115e5870f0c13f52", columns={"cancellation_policy_id"})})
 * @ORM\Entity
 */
class CancellationPolicyRule
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cancellation_policy_rule_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="upper_bound", type="integer", nullable=false)
     */
    private $upperBound;

    /**
     * @var int
     *
     * @ORM\Column(name="bottom_bound", type="integer", nullable=false)
     */
    private $bottomBound;

    /**
     * @var float
     *
     * @ORM\Column(name="variation_amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $variationAmount;

    /**
     * @var \CancellationPolicy
     *
     * @ORM\ManyToOne(targetEntity="CancellationPolicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cancellation_policy_id", referencedColumnName="id")
     * })
     */
    private $cancellationPolicy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpperBound(): ?int
    {
        return $this->upperBound;
    }

    public function setUpperBound(int $upperBound): self
    {
        $this->upperBound = $upperBound;

        return $this;
    }

    public function getBottomBound(): ?int
    {
        return $this->bottomBound;
    }

    public function setBottomBound(int $bottomBound): self
    {
        $this->bottomBound = $bottomBound;

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

    public function getCancellationPolicy(): ?CancellationPolicy
    {
        return $this->cancellationPolicy;
    }

    public function setCancellationPolicy(?CancellationPolicy $cancellationPolicy): self
    {
        $this->cancellationPolicy = $cancellationPolicy;

        return $this;
    }


}
