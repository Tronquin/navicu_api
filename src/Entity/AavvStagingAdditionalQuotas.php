<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AavvStagingAdditionalQuotas
 *
 * @ORM\Table(name="aavv_staging_additional_quotas", indexes={@ORM\Index(name="idx_be4dadb6ace1b2d7", columns={"targetid"})})
 * @ORM\Entity
 */
class AavvStagingAdditionalQuotas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavv_staging_additional_quotas_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="oldamount", type="integer", nullable=true)
     */
    private $oldamount;

    /**
     * @var int
     *
     * @ORM\Column(name="newamount", type="integer", nullable=false)
     */
    private $newamount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="valid_since", type="date", nullable=false)
     */
    private $validSince;

    /**
     * @var bool
     *
     * @ORM\Column(name="applied", type="boolean", nullable=false)
     */
    private $applied = false;

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
     * @var \AavvAdditionalQuota
     *
     * @ORM\ManyToOne(targetEntity="AavvAdditionalQuota")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="targetid", referencedColumnName="id")
     * })
     */
    private $targetid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldamount(): ?int
    {
        return $this->oldamount;
    }

    public function setOldamount(?int $oldamount): self
    {
        $this->oldamount = $oldamount;

        return $this;
    }

    public function getNewamount(): ?int
    {
        return $this->newamount;
    }

    public function setNewamount(int $newamount): self
    {
        $this->newamount = $newamount;

        return $this;
    }

    public function getValidSince(): ?\DateTimeInterface
    {
        return $this->validSince;
    }

    public function setValidSince(\DateTimeInterface $validSince): self
    {
        $this->validSince = $validSince;

        return $this;
    }

    public function getApplied(): ?bool
    {
        return $this->applied;
    }

    public function setApplied(bool $applied): self
    {
        $this->applied = $applied;

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

    public function getTargetid(): ?AavvAdditionalQuota
    {
        return $this->targetid;
    }

    public function setTargetid(?AavvAdditionalQuota $targetid): self
    {
        $this->targetid = $targetid;

        return $this;
    }


}
