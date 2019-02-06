<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * FosUser
 *
 * @ORM\Table(name="fos_user", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_957a64791e342518", columns={"temp_owner_id"}), @ORM\UniqueConstraint(name="uniq_957a6479289427d2", columns={"aavv_profile_id"}), @ORM\UniqueConstraint(name="uniq_957a64791716ede3", columns={"nvc_profile_id"}), @ORM\UniqueConstraint(name="uniq_957a64799e908bfd", columns={"owner_profile_id"}), @ORM\UniqueConstraint(name="uniq_957a6479a0d96fbf", columns={"email_canonical"}), @ORM\UniqueConstraint(name="uniq_957a64792995fd7e", columns={"reservation_change_history_id"}), @ORM\UniqueConstraint(name="uniq_957a647992fc23a8", columns={"username_canonical"})}, indexes={@ORM\Index(name="idx_957a64798530a5dc", columns={"subdomain_id"}), @ORM\Index(name="idx_957a6479a108e8d", columns={"logs_users_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\FosUserRepository")
 */
class FosUser implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="fos_user_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="username_canonical", type="string", length=255, nullable=false)
     */
    private $usernameCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=255, nullable=false)
     */
    private $emailCanonical;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var string   
     * @ORM\Column(name="password", type="string", length=255)
     */     
    private $password;

 
    protected $plainPassword;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var bool
     *
     * @ORM\Column(name="locked", type="boolean", nullable=false)
     */
    private $locked;

    /**
     * @var bool
     *
     * @ORM\Column(name="expired", type="boolean", nullable=false)
     */
    private $expired;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    private $expiresAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="confirmation_token", type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    private $passwordRequestedAt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array", nullable=false)
     */
    private $roles;

    /**
     * @var bool
     *
     * @ORM\Column(name="credentials_expired", type="boolean", nullable=false)
     */
    private $credentialsExpired;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    private $credentialsExpireAt;

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
     * @var bool|null
     *
     * @ORM\Column(name="disable_advance", type="boolean", nullable=true)
     */
    private $disableAdvance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reference", type="string", nullable=true)
     */
    private $reference;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="reference_date", type="datetime", nullable=true)
     */
    private $referenceDate;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nvc_profile_id", referencedColumnName="id")
     * })
     */
    private $nvcProfile;

    /**
     * @var \Tempowner
     *
     * @ORM\ManyToOne(targetEntity="Tempowner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="temp_owner_id", referencedColumnName="id")
     * })
     */
    private $tempOwner;

    /**
     * @var \AavvProfile
     *
     * @ORM\ManyToOne(targetEntity="AavvProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv_profile_id", referencedColumnName="id")
     * })
     */
    private $aavvProfile;

    /**
     * @var \ReservationChangeHistory
     *
     * @ORM\ManyToOne(targetEntity="ReservationChangeHistory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_change_history_id", referencedColumnName="id")
     * })
     */
    private $reservationChangeHistory;

    /**
     * @var \Subdomain
     *
     * @ORM\ManyToOne(targetEntity="Subdomain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subdomain_id", referencedColumnName="id")
     * })
     */
    private $subdomain;

    /**
     * @var \OwnerProfile
     *
     * @ORM\ManyToOne(targetEntity="OwnerProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_profile_id", referencedColumnName="id")
     * })
     */
    private $ownerProfile;

    /**
     * @var \LogsUser
     *
     * @ORM\ManyToOne(targetEntity="LogsUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logs_users_id", referencedColumnName="id")
     * })
     */
    private $logsUsers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="user")
     * @ORM\JoinTable(name="user_roles",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *   }
     * )
     */
    private $role;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsernameCanonical(): ?string
    {
        return $this->usernameCanonical;
    }

    public function setUsernameCanonical(string $usernameCanonical): self
    {
        $this->usernameCanonical = $usernameCanonical;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    public function setEmailCanonical(string $emailCanonical): self
    {
        $this->emailCanonical = $emailCanonical;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function eraseCredentials() {}

    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        $this->password = null;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getExpired(): ?bool
    {
        return $this->expired;
    }

    public function setExpired(bool $expired): self
    {
        $this->expired = $expired;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getPasswordRequestedAt(): ?\DateTimeInterface
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequestedAt(?\DateTimeInterface $passwordRequestedAt): self
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }
  
    public function getRoles()
    {
        return ["ROLE_USER"];
    }
    
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCredentialsExpired(): ?bool
    {
        return $this->credentialsExpired;
    }

    public function setCredentialsExpired(bool $credentialsExpired): self
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    public function getCredentialsExpireAt(): ?\DateTimeInterface
    {
        return $this->credentialsExpireAt;
    }

    public function setCredentialsExpireAt(?\DateTimeInterface $credentialsExpireAt): self
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

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

    public function getDisableAdvance(): ?bool
    {
        return $this->disableAdvance;
    }

    public function setDisableAdvance(?bool $disableAdvance): self
    {
        $this->disableAdvance = $disableAdvance;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReferenceDate(): ?\DateTimeInterface
    {
        return $this->referenceDate;
    }

    public function setReferenceDate(?\DateTimeInterface $referenceDate): self
    {
        $this->referenceDate = $referenceDate;

        return $this;
    }

    public function getNvcProfile(): ?NvcProfile
    {
        return $this->nvcProfile;
    }

    public function setNvcProfile(?NvcProfile $nvcProfile): self
    {
        $this->nvcProfile = $nvcProfile;

        return $this;
    }

    public function getTempOwner(): ?Tempowner
    {
        return $this->tempOwner;
    }

    public function setTempOwner(?Tempowner $tempOwner): self
    {
        $this->tempOwner = $tempOwner;

        return $this;
    }

    public function getAavvProfile(): ?AavvProfile
    {
        return $this->aavvProfile;
    }

    public function setAavvProfile(?AavvProfile $aavvProfile): self
    {
        $this->aavvProfile = $aavvProfile;

        return $this;
    }

    public function getReservationChangeHistory(): ?ReservationChangeHistory
    {
        return $this->reservationChangeHistory;
    }

    public function setReservationChangeHistory(?ReservationChangeHistory $reservationChangeHistory): self
    {
        $this->reservationChangeHistory = $reservationChangeHistory;

        return $this;
    }

    public function getSubdomain(): ?Subdomain
    {
        return $this->subdomain;
    }

    public function setSubdomain(?Subdomain $subdomain): self
    {
        $this->subdomain = $subdomain;

        return $this;
    }

    public function getOwnerProfile(): ?OwnerProfile
    {
        return $this->ownerProfile;
    }

    public function setOwnerProfile(?OwnerProfile $ownerProfile): self
    {
        $this->ownerProfile = $ownerProfile;

        return $this;
    }

    public function getLogsUsers(): ?LogsUser
    {
        return $this->logsUsers;
    }

    public function setLogsUsers(?LogsUser $logsUsers): self
    {
        $this->logsUsers = $logsUsers;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(Role $role): self
    {
        if (!$this->role->contains($role)) {
            $this->role[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->role->contains($role)) {
            $this->role->removeElement($role);
        }

        return $this;
    }

}
