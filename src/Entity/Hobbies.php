<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hobbies
 *
 * @ORM\Table(name="hobbies")
 * @ORM\Entity
 */
class Hobbies
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="hobbies_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ClientProfile", mappedBy="hobbies")
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
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

    /**
     * @return Collection|ClienteProfile[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(ClienteProfile $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->addHobby($this);
        }

        return $this;
    }

    public function removeClient(ClienteProfile $client): self
    {
        if ($this->client->contains($client)) {
            $this->client->removeElement($client);
            $client->removeHobby($this);
        }

        return $this;
    }

}
