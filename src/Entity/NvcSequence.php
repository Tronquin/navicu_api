<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NvcSequence
 *
 * @ORM\Table(name="nvc_sequence")
 * @ORM\Entity
 */
class NvcSequence
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="nvc_sequence_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prefix", type="string", length=255, nullable=true)
     */
    private $prefix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sufix", type="string", length=255, nullable=true)
     */
    private $sufix;

    /**
     * @var int
     *
     * @ORM\Column(name="currentnext", type="integer", nullable=false)
     */
    private $currentnext;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getSufix(): ?string
    {
        return $this->sufix;
    }

    public function setSufix(?string $sufix): self
    {
        $this->sufix = $sufix;

        return $this;
    }

    public function getCurrentnext(): ?int
    {
        return $this->currentnext;
    }

    public function setCurrentnext(int $currentnext): self
    {
        $this->currentnext = $currentnext;

        return $this;
    }


}
