<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aavvlogs
 *
 * @ORM\Table(name="aavvlogs")
 * @ORM\Entity
 */
class Aavvlogs
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="aavvlogs_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aavv_id", type="integer", nullable=true)
     */
    private $aavvId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="entity", type="string", length=255, nullable=false)
     */
    private $entity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var int|null
     *
     * @ORM\Column(name="entity_id", type="integer", nullable=true)
     */
    private $entityId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="field", type="string", length=255, nullable=true)
     */
    private $field;

    /**
     * @var string|null
     *
     * @ORM\Column(name="oldvalue", type="string", length=255, nullable=true)
     */
    private $oldvalue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="newvalue", type="string", length=255, nullable=true)
     */
    private $newvalue;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAavvId(): ?int
    {
        return $this->aavvId;
    }

    public function setAavvId(?int $aavvId): self
    {
        $this->aavvId = $aavvId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityId(?int $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(?string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getOldvalue(): ?string
    {
        return $this->oldvalue;
    }

    public function setOldvalue(?string $oldvalue): self
    {
        $this->oldvalue = $oldvalue;

        return $this;
    }

    public function getNewvalue(): ?string
    {
        return $this->newvalue;
    }

    public function setNewvalue(?string $newvalue): self
    {
        $this->newvalue = $newvalue;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


}
