<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthAuthCode
 *
 * @ORM\Table(name="oauth_auth_code", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_4d12f0e05f37a13b", columns={"token"})}, indexes={@ORM\Index(name="idx_4d12f0e0a76ed395", columns={"user_id"}), @ORM\Index(name="idx_4d12f0e0dca49ed", columns={"oauth_client_id"})})
 * @ORM\Entity
 */
class OauthAuthCode
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="oauth_auth_code_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect_uri", type="text", nullable=false)
     */
    private $redirectUri;

    /**
     * @var int|null
     *
     * @ORM\Column(name="expires_at", type="integer", nullable=true)
     */
    private $expiresAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="scope", type="string", length=255, nullable=true)
     */
    private $scope;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \OauthClient
     *
     * @ORM\ManyToOne(targetEntity="OauthClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="oauth_client_id", referencedColumnName="id")
     * })
     */
    private $oauthClient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    public function setRedirectUri(string $redirectUri): self
    {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    public function getExpiresAt(): ?int
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?int $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(?string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getUser(): ?FosUser
    {
        return $this->user;
    }

    public function setUser(?FosUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOauthClient(): ?OauthClient
    {
        return $this->oauthClient;
    }

    public function setOauthClient(?OauthClient $oauthClient): self
    {
        $this->oauthClient = $oauthClient;

        return $this;
    }


}
