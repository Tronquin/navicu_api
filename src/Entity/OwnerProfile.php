<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OwnerProfile
 *
 * @ORM\Table(name="owner_profile", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_d212cd0a76ed395", columns={"user_id"})}, indexes={@ORM\Index(name="idx_d212cd0727aca70", columns={"parent_id"}), @ORM\Index(name="idx_d212cd0ffa0c224", columns={"office_id"}), @ORM\Index(name="idx_d212cd064d218e", columns={"location_id"})})
 * @ORM\Entity
 */
class OwnerProfile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="owner_profile_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="names", type="string", length=150, nullable=true)
     */
    private $names;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_names", type="string", length=150, nullable=true)
     */
    private $lastNames;

    /**
     * @var array|null
     *
     * @ORM\Column(name="phones", type="array", length=255, nullable=true)
     */
    private $phones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fax", type="string", length=25, nullable=true)
     */
    private $fax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=true)
     */
    private $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="identity_card", type="string", length=255, nullable=true)
     */
    private $identityCard;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    private $gender;

    /**
     * @var string|null
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @var string|null
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="joined_date", type="datetime", nullable=true)
     */
    private $joinedDate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="email_news", type="boolean", nullable=true, options={"default"="1"})
     */
    private $emailNews = true;

    /**
     * @var int|null
     *
     * @ORM\Column(name="treatment", type="integer", nullable=true)
     */
    private $treatment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cell_phone", type="string", length=255, nullable=true)
     */
    private $cellPhone;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     * })
     */
    private $location;

    /**
     * @var \OwnerProfile
     *
     * @ORM\ManyToOne(targetEntity="OwnerProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
     */
    private $parent;

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
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="office_id", referencedColumnName="id")
     * })
     */
    private $office;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Property", inversedBy="ownerprofile")
     * @ORM\JoinTable(name="owner_property",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ownerprofile_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     *   }
     * )
     */
    private $property;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->property = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNames(): ?string
    {
        return $this->names;
    }

    public function setNames(?string $names): self
    {
        $this->names = $names;

        return $this;
    }

    public function getLastNames(): ?string
    {
        return $this->lastNames;
    }

    public function setLastNames(?string $lastNames): self
    {
        $this->lastNames = $lastNames;

        return $this;
    }

    public function getPhones(): ?array
    {
        return $this->phones;
    }

    public function setPhones(?array $phones): self
    {
        $this->phones = $phones;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getIdentityCard(): ?string
    {
        return $this->identityCard;
    }

    public function setIdentityCard(?string $identityCard): self
    {
        $this->identityCard = $identityCard;

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

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(?int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

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

    public function getEmailNews(): ?bool
    {
        return $this->emailNews;
    }

    public function setEmailNews(?bool $emailNews): self
    {
        $this->emailNews = $emailNews;

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

    public function getCellPhone(): ?string
    {
        return $this->cellPhone;
    }

    public function setCellPhone(?string $cellPhone): self
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

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

    public function getOffice(): ?Categories
    {
        return $this->office;
    }

    public function setOffice(?Categories $office): self
    {
        $this->office = $office;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->property->contains($property)) {
            $this->property->removeElement($property);
        }

        return $this;
    }

}
