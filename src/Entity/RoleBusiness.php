<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleBusiness
 *
 * @ORM\Table(name="role_business", indexes={@ORM\Index(name="_22008809d60322ac", columns={"role_id"})})
 * @ORM\Entity
 */
class RoleBusiness
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="role_business_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="admin_business", type="boolean", nullable=false)
     */
    private $adminBusiness;

    /**
     * @var int
     *
     * @ORM\Column(name="min_commission", type="integer", nullable=false)
     */
    private $minCommission;

    /**
     * @var int
     *
     * @ORM\Column(name="max_commission", type="integer", nullable=false)
     */
    private $maxCommission;

    /**
     * @var \Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdminBusiness(): ?bool
    {
        return $this->adminBusiness;
    }

    public function setAdminBusiness(bool $adminBusiness): self
    {
        $this->adminBusiness = $adminBusiness;

        return $this;
    }

    public function getMinCommission(): ?int
    {
        return $this->minCommission;
    }

    public function setMinCommission(int $minCommission): self
    {
        $this->minCommission = $minCommission;

        return $this;
    }

    public function getMaxCommission(): ?int
    {
        return $this->maxCommission;
    }

    public function setMaxCommission(int $maxCommission): self
    {
        $this->maxCommission = $maxCommission;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }


}
