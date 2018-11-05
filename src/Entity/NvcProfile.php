<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NvcProfile
 *
 * @ORM\Table(name="nvc_profile", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_67a1d077a76ed395", columns={"user_id"})}, indexes={@ORM\Index(name="idx_67a1d07748b3eee4", columns={"departament_id"})})
 * @ORM\Entity
 */
class NvcProfile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="nvc_profile_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=false)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="identity_card", type="string", length=255, nullable=false)
     */
    private $identityCard;

    /**
     * @var int|null
     *
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    private $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="company_email", type="string", length=255, nullable=true)
     */
    private $companyEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="personal_email", type="string", length=255, nullable=true)
     */
    private $personalEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cell_phone", type="string", length=255, nullable=true)
     */
    private $cellPhone;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="joined_date", type="datetime", nullable=true)
     */
    private $joinedDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="personal_phone", type="string", length=255, nullable=true)
     */
    private $personalPhone;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="incorporation_date", type="date", nullable=true)
     */
    private $incorporationDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="treatment", type="integer", nullable=true)
     */
    private $treatment = '0';

    /**
     * @var array
     *
     * @ORM\Column(name="permissions", type="json_array", nullable=false, options={"default"="[]"})
     */
    private $permissions = '[]';

    /**
     * @var string|null
     *
     * @ORM\Column(name="corporate_phone", type="string", length=255, nullable=true)
     */
    private $corporatePhone;

    /**
     * @var \Departament
     *
     * @ORM\ManyToOne(targetEntity="Departament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departament_id", referencedColumnName="id")
     * })
     */
    private $departament;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getIdentityCard(): ?string
    {
        return $this->identityCard;
    }

    public function setIdentityCard(string $identityCard): self
    {
        $this->identityCard = $identityCard;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(?string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;

        return $this;
    }

    public function getPersonalEmail(): ?string
    {
        return $this->personalEmail;
    }

    public function setPersonalEmail(?string $personalEmail): self
    {
        $this->personalEmail = $personalEmail;

        return $this;
    }

    public function getCellPhone(): ?string
    {
        return $this->cellPhone;
    }

    public function setCellPhone(?string $cellPhone): self
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getJoinedDate(): ?\DateTimeInterface
    {
        return $this->joinedDate;
    }

    public function setJoinedDate(?\DateTimeInterface $joinedDate): self
    {
        $this->joinedDate = $joinedDate;

        return $this;
    }

    public function getPersonalPhone(): ?string
    {
        return $this->personalPhone;
    }

    public function setPersonalPhone(?string $personalPhone): self
    {
        $this->personalPhone = $personalPhone;

        return $this;
    }

    public function getIncorporationDate(): ?\DateTimeInterface
    {
        return $this->incorporationDate;
    }

    public function setIncorporationDate(?\DateTimeInterface $incorporationDate): self
    {
        $this->incorporationDate = $incorporationDate;

        return $this;
    }

    public function getTreatment(): ?int
    {
        return $this->treatment;
    }

    public function setTreatment(?int $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setPermissions($permissions): self
    {
        $this->permissions = $permissions;

        return $this;
    }

    public function getCorporatePhone(): ?string
    {
        return $this->corporatePhone;
    }

    public function setCorporatePhone(?string $corporatePhone): self
    {
        $this->corporatePhone = $corporatePhone;

        return $this;
    }

    public function getDepartament(): ?Departament
    {
        return $this->departament;
    }

    public function setDepartament(?Departament $departament): self
    {
        $this->departament = $departament;

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


}
