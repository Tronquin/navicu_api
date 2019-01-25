<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DropDaily
 *
 * @ORM\Table(name="drop_daily")
 * @ORM\Entity
 */
class DropDaily
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="drop_daily_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="daily_id", type="integer", nullable=false)
     */
    private $dailyId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=false)
     */
    private $parentId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDailyId(): ?int
    {
        return $this->dailyId;
    }

    public function setDailyId(int $dailyId): self
    {
        $this->dailyId = $dailyId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }


}
