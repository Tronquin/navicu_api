<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthClient
 *
 * @ORM\Table(name="oauth_client")
 * @ORM\Entity
 */
class OauthClient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="oauth_client_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="random_id", type="string", length=255, nullable=false)
     */
    private $randomId;

    /**
     * @var array
     *
     * @ORM\Column(name="redirect_uris", type="array", nullable=false)
     */
    private $redirectUris;

    /**
     * @var string
     *
     * @ORM\Column(name="secret", type="string", length=255, nullable=false)
     */
    private $secret;

    /**
     * @var array
     *
     * @ORM\Column(name="allowed_grant_types", type="array", nullable=false)
     */
    private $allowedGrantTypes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRandomId(): ?string
    {
        return $this->randomId;
    }

    public function setRandomId(string $randomId): self
    {
        $this->randomId = $randomId;

        return $this;
    }

    public function getRedirectUris(): ?array
    {
        return $this->redirectUris;
    }

    public function setRedirectUris(array $redirectUris): self
    {
        $this->redirectUris = $redirectUris;

        return $this;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getAllowedGrantTypes(): ?array
    {
        return $this->allowedGrantTypes;
    }

    public function setAllowedGrantTypes(array $allowedGrantTypes): self
    {
        $this->allowedGrantTypes = $allowedGrantTypes;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


}
