<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role", indexes={@ORM\Index(name="idx_57698a6a2bc8e414", columns={"aavv"})})
 * @ORM\Entity
 */
class Role
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="role_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

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
     * @var bool
     *
     * @ORM\Column(name="admin", type="boolean", nullable=false)
     */
    private $admin = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="userreadablename", type="string", length=255, nullable=true)
     */
    private $userreadablename;

    /**
     * @var \Aavv
     *
     * @ORM\ManyToOne(targetEntity="Aavv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aavv", referencedColumnName="id")
     * })
     */
    private $aavv;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Module", inversedBy="role")
     * @ORM\JoinTable(name="role_modules",
     *   joinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     *   }
     * )
     */
    private $module;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Permission", inversedBy="role")
     * @ORM\JoinTable(name="role_permissions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     *   }
     * )
     */
    private $permission;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="FosUser", mappedBy="role")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->module = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permission = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getUserreadablename(): ?string
    {
        return $this->userreadablename;
    }

    public function setUserreadablename(?string $userreadablename): self
    {
        $this->userreadablename = $userreadablename;

        return $this;
    }

    public function getAavv(): ?Aavv
    {
        return $this->aavv;
    }

    public function setAavv(?Aavv $aavv): self
    {
        $this->aavv = $aavv;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function addModule(Module $module): self
    {
        if (!$this->module->contains($module)) {
            $this->module[] = $module;
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->module->contains($module)) {
            $this->module->removeElement($module);
        }

        return $this;
    }

    /**
     * @return Collection|Permission[]
     */
    public function getPermission(): Collection
    {
        return $this->permission;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permission->contains($permission)) {
            $this->permission[] = $permission;
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        if ($this->permission->contains($permission)) {
            $this->permission->removeElement($permission);
        }

        return $this;
    }

    /**
     * @return Collection|FosUser[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(FosUser $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->addRole($this);
        }

        return $this;
    }

    public function removeUser(FosUser $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            $user->removeRole($this);
        }

        return $this;
    }

}
