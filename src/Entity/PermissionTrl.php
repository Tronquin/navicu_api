<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PermissionTrl
 *
 * @ORM\Table(name="permission_trl", indexes={@ORM\Index(name="idx_e52fb5a857698a6a", columns={"permission"})})
 * @ORM\Entity
 */
class PermissionTrl
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="permission_trl_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=255, nullable=false)
     */
    private $locale;

    /**
     * @var \Permission
     *
     * @ORM\ManyToOne(targetEntity="Permission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="permission", referencedColumnName="id")
     * })
     */
    private $permission;

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

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getPermission(): ?Permission
    {
        return $this->permission;
    }

    public function setPermission(?Permission $permission): self
    {
        $this->permission = $permission;

        return $this;
    }


}
