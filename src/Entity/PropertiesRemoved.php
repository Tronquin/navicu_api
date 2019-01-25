<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertiesRemoved
 *
 * @ORM\Table(name="properties_removed", indexes={@ORM\Index(name="idx_20e9fb50549213ec", columns={"property_id"}), @ORM\Index(name="idx_20e9fb50a76ed395", columns={"user_id"})})
 * @ORM\Entity
 */
class PropertiesRemoved
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="properties_removed_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="text", nullable=false)
     */
    private $reason;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reason_date", type="datetime", nullable=false)
     */
    private $reasonDate;

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
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getReasonDate(): ?\DateTimeInterface
    {
        return $this->reasonDate;
    }

    public function setReasonDate(\DateTimeInterface $reasonDate): self
    {
        $this->reasonDate = $reasonDate;

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

    public function getUser(): ?NvcProfile
    {
        return $this->user;
    }

    public function setUser(?NvcProfile $user): self
    {
        $this->user = $user;

        return $this;
    }


}
