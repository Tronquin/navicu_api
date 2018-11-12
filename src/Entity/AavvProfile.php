<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AavvProfile
 *
 * @ORM\Table(name="aavv_profile", indexes={@ORM\Index(name="idx_b1ab746bd2c3b2dd", columns={"aavv_id"}), @ORM\Index(name="idx_b1ab746b64d218e", columns={"location_id"})})
 * @ORM\Entity
 */
class AavvProfile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_profile_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fullname", type="string", length=150, nullable=true)
     */
    private $fullname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @var string|null
     *
     * @ORM\Column(name="document_id", type="string", length=255, nullable=true)
     */
    private $documentId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var int|null
     *
     * @ORM\Column(name="profileorder", type="integer", nullable=true)
     */
    private $profileorder;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="confirmationemailreceiver", type="boolean", nullable=true)
     */
    private $confirmationemailreceiver;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="cancellationemailreceiver", type="boolean", nullable=true)
     */
    private $cancellationemailreceiver;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="newsemailreceiver", type="boolean", nullable=true)
     */
    private $newsemailreceiver;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_activation", type="datetime", nullable=true)
     */
    private $lastActivation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \Aavv
     *
     * @ORM\ManyToOne(targetEntity="Aavv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_id", referencedColumnName="id")
     * })
     */
    private $aavv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    public function setDocumentId(?string $documentId): self
    {
        $this->documentId = $documentId;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getProfileorder(): ?int
    {
        return $this->profileorder;
    }

    public function setProfileorder(?int $profileorder): self
    {
        $this->profileorder = $profileorder;

        return $this;
    }

    public function getConfirmationemailreceiver(): ?bool
    {
        return $this->confirmationemailreceiver;
    }

    public function setConfirmationemailreceiver(?bool $confirmationemailreceiver): self
    {
        $this->confirmationemailreceiver = $confirmationemailreceiver;

        return $this;
    }

    public function getCancellationemailreceiver(): ?bool
    {
        return $this->cancellationemailreceiver;
    }

    public function setCancellationemailreceiver(?bool $cancellationemailreceiver): self
    {
        $this->cancellationemailreceiver = $cancellationemailreceiver;

        return $this;
    }

    public function getNewsemailreceiver(): ?bool
    {
        return $this->newsemailreceiver;
    }

    public function setNewsemailreceiver(?bool $newsemailreceiver): self
    {
        $this->newsemailreceiver = $newsemailreceiver;

        return $this;
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

    public function getLastActivation(): ?\DateTimeInterface
    {
        return $this->lastActivation;
    }

    public function setLastActivation(?\DateTimeInterface $lastActivation): self
    {
        $this->lastActivation = $lastActivation;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getAavv(): ?Aavv
    {
        return $this->aavv;
    }

    public function setAavv(?Aavv $aavv): self
    {
        $this->aavv = $aavv;

        return $this;
    }


}
