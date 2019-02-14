<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RedSocial
 *
 * @ORM\Table(name="red_social", indexes={@ORM\Index(name="idx_465d8e0319eb6921", columns={"client_id"})})
 * @ORM\Entity
 */
class RedSocial
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="red_social_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="id_social", type="string", length=255, nullable=false)
     */
    private $idSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var int|null
     *
     * @ORM\Column(name="age_range", type="integer", nullable=true)
     */
    private $ageRange;

    /**
     * @var \ClientProfile
     *
     * @ORM\ManyToOne(targetEntity="ClientProfile", inversedBy="redSocial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     */
    private $client;

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSocial(): ?string
    {
        return $this->idSocial;
    }

    public function setIdSocial(string $idSocial): self
    {
        $this->idSocial = $idSocial;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getAgeRange(): ?int
    {
        return $this->ageRange;
    }

    public function setAgeRange(?int $ageRange): self
    {
        $this->ageRange = $ageRange;

        return $this;
    }

    public function getClient(): ?ClientProfile
    {
        return $this->client;
    }

    public function setClient(?ClientProfile $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * La función actualiza los datos de una RedSocial, dado un array ($data).
     *
     * @author Currently Working: Javier Vasquez
     *
     * @param Array $data
     * @return void
     */ 
    public function updateObject($data, &$client)
    {
        $this->setIdSocial($data["user_id"]);
        $this->setType($data["type"]);
        $this->setLink($data["url"]);
        $this->setPhoto("undefined");
        $this->setAgeRange(0);
        $this->setClient($client);
        $client->addRedSocial($this);

        return $this;
    }

}
