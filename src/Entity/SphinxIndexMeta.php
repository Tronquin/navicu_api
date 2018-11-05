<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SphinxIndexMeta
 *
 * @ORM\Table(name="sphinx_index_meta")
 * @ORM\Entity
 */
class SphinxIndexMeta
{
    /**
     * @var string
     *
     * @ORM\Column(name="index_name", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sphinx_index_meta_index_name_seq", allocationSize=1, initialValue=1)
     */
    private $indexName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_id", type="integer", nullable=true)
     */
    private $maxId;

    /**
     * @var int
     *
     * @ORM\Column(name="last_update", type="integer", nullable=false)
     */
    private $lastUpdate;

    public function getIndexName(): ?string
    {
        return $this->indexName;
    }

    public function getMaxId(): ?int
    {
        return $this->maxId;
    }

    public function setMaxId(?int $maxId): self
    {
        $this->maxId = $maxId;

        return $this;
    }

    public function getLastUpdate(): ?int
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(int $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }


}
