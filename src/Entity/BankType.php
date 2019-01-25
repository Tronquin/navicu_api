<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankType
 *
 * @ORM\Table(name="bank_type")
  * @ORM\Entity(repositoryClass="App\Repository\BankTypeRepository"))
 */
class BankType
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bank_type_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="location_zone", type="integer", nullable=false, options={"default"="1"})
     */
    private $locationZone = '1';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="receiver", type="boolean", nullable=true)
     */
    private $receiver;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLocationZone(): ?int
    {
        return $this->locationZone;
    }

    public function setLocationZone(int $locationZone): self
    {
        $this->locationZone = $locationZone;

        return $this;
    }

    public function getReceiver(): ?bool
    {
        return $this->receiver;
    }

    public function setReceiver(?bool $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }


}
