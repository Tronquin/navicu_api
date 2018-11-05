<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationGroup
 *
 * @ORM\Table(name="reservation_group", indexes={@ORM\Index(name="idx_2ebf946264d218e", columns={"location_id"}), @ORM\Index(name="idx_2ebf9462cde7c497", columns={"aavv_invoice_id"}), @ORM\Index(name="idx_2ebf9462d2c3b2dd", columns={"aavv_id"}), @ORM\Index(name="idx_2ebf9462289427d2", columns={"aavv_profile_id"})})
 * @ORM\Entity
 */
class ReservationGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="reservation_group_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=false)
     */
    private $publicId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_check_in", type="date", nullable=false)
     */
    private $dateCheckIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_check_out", type="date", nullable=false)
     */
    private $dateCheckOut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=true)
     */
    private $createdat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="createdby", type="integer", nullable=true)
     */
    private $createdby;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updatedat", type="datetime", nullable=true)
     */
    private $updatedat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="updatedby", type="integer", nullable=true)
     */
    private $updatedby;

    /**
     * @var float|null
     *
     * @ORM\Column(name="total_amount", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalAmount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="hash_url", type="string", length=255, nullable=true)
     */
    private $hashUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="createdbyadmin", type="boolean", nullable=false)
     */
    private $createdbyadmin = false;

    /**
     * @var \AavvProfile
     *
     * @ORM\ManyToOne(targetEntity="AavvProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_profile_id", referencedColumnName="id")
     * })
     */
    private $aavvProfile;

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
     * @var \AavvInvoice
     *
     * @ORM\ManyToOne(targetEntity="AavvInvoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_invoice_id", referencedColumnName="id")
     * })
     */
    private $aavvInvoice;

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

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
    }

    public function getDateCheckIn(): ?\DateTimeInterface
    {
        return $this->dateCheckIn;
    }

    public function setDateCheckIn(\DateTimeInterface $dateCheckIn): self
    {
        $this->dateCheckIn = $dateCheckIn;

        return $this;
    }

    public function getDateCheckOut(): ?\DateTimeInterface
    {
        return $this->dateCheckOut;
    }

    public function setDateCheckOut(\DateTimeInterface $dateCheckOut): self
    {
        $this->dateCheckOut = $dateCheckOut;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(?\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getCreatedby(): ?int
    {
        return $this->createdby;
    }

    public function setCreatedby(?int $createdby): self
    {
        $this->createdby = $createdby;

        return $this;
    }

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(?\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getUpdatedby(): ?int
    {
        return $this->updatedby;
    }

    public function setUpdatedby(?int $updatedby): self
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getHashUrl(): ?string
    {
        return $this->hashUrl;
    }

    public function setHashUrl(?string $hashUrl): self
    {
        $this->hashUrl = $hashUrl;

        return $this;
    }

    public function getCreatedbyadmin(): ?bool
    {
        return $this->createdbyadmin;
    }

    public function setCreatedbyadmin(bool $createdbyadmin): self
    {
        $this->createdbyadmin = $createdbyadmin;

        return $this;
    }

    public function getAavvProfile(): ?AavvProfile
    {
        return $this->aavvProfile;
    }

    public function setAavvProfile(?AavvProfile $aavvProfile): self
    {
        $this->aavvProfile = $aavvProfile;

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

    public function getAavvInvoice(): ?AavvInvoice
    {
        return $this->aavvInvoice;
    }

    public function setAavvInvoice(?AavvInvoice $aavvInvoice): self
    {
        $this->aavvInvoice = $aavvInvoice;

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
