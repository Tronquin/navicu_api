<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ClientProfile
 *
 * @ORM\Table(name="cliente_profile", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_60e631fba76ed395", columns={"user_id"})}, indexes={@ORM\Index(name="idx_60e631fb64d218e", columns={"location_id"})})
 * @ORM\Entity
 */
class ClientProfile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="cliente_profile_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=false)
     */
    private $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="identity_card", type="string", length=255, nullable=true)
     */
    private $identityCard;

    /**
     * @var int|null
     *
     * @ORM\Column(name="gender", type="integer", nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var bool
     *
     * @ORM\Column(name="email_news", type="boolean", nullable=false)
     */
    private $emailNews;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="country", type="integer", nullable=true)
     */
    private $country;

    /**
     * @var int|null
     *
     * @ORM\Column(name="state", type="integer", nullable=true)
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="joined_date", type="datetime", nullable=true)
     */
    private $joinedDate;

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
     * @var int|null
     *
     * @ORM\Column(name="treatment", type="integer", nullable=true)
     */
    private $treatment;

    /**
     * @var string|null
     *
     * @ORM\Column(name="typeidentity", type="string", length=255, nullable=true)
     */
    private $typeidentity;

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
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Profession", inversedBy="client")
     * @ORM\JoinTable(name="client_professions",
     *   joinColumns={
     *     @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     *   }
     * )
     */
    private $profession;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Hobbies", inversedBy="client")
     * @ORM\JoinTable(name="client_hobbies",
     *   joinColumns={
     *     @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="hobbies_id", referencedColumnName="id")
     *   }
     * )
     */
    private $hobbies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RedSocial", mappedBy="clientProfile")
     */
    private $redSocial;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FlightReservation", mappedBy="clientProfile")
     */
    private $flightReservations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profession = new \Doctrine\Common\Collections\ArrayCollection();
        $this->hobbies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->redSocial = new ArrayCollection();
        $this->flightReservations = new ArrayCollection();
    }

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

    public function setIdentityCard(?string $identityCard): self
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmailNews(): ?bool
    {
        return $this->emailNews;
    }

    public function setEmailNews(bool $emailNews): self
    {
        $this->emailNews = $emailNews;

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

    public function getCountry(): ?int
    {
        return $this->country;
    }

    public function setCountry(?int $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

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

    public function getTreatment(): ?int
    {
        return $this->treatment;
    }

    public function setTreatment(?int $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getTypeidentity(): ?string
    {
        return $this->typeidentity;
    }

    public function setTypeidentity(?string $typeidentity): self
    {
        $this->typeidentity = $typeidentity;

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

    public function getUser(): ?FosUser
    {
        return $this->user;
    }

    public function setUser(?FosUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Profession[]
     */
    public function getProfession(): Collection
    {
        return $this->profession;
    }

    public function addProfession(Profession $profession): self
    {
        if (!$this->profession->contains($profession)) {
            $this->profession[] = $profession;
        }

        return $this;
    }

    public function removeProfession(Profession $profession): self
    {
        if ($this->profession->contains($profession)) {
            $this->profession->removeElement($profession);
        }

        return $this;
    }

    /**
     * @return Collection|Hobbies[]
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobbies $hobby): self
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies[] = $hobby;
        }

        return $this;
    }

    public function removeHobby(Hobbies $hobby): self
    {
        if ($this->hobbies->contains($hobby)) {
            $this->hobbies->removeElement($hobby);
        }

        return $this;
    }

    /**
     * @return Collection|RedSocial[]
     */
    public function getRedSocial(): Collection
    {
        return $this->redSocial;
    }

    public function addRedSocial(RedSocial $redSocial): self
    {
        if (!$this->redSocial->contains($redSocial)) {
            $this->redSocial[] = $redSocial;
            $redSocial->setClient($this);
        }

        return $this;
    }

    public function removeRedSocial(RedSocial $redSocial): self
    {
        if ($this->redSocial->contains($redSocial)) {
            $this->redSocial->removeElement($redSocial);
            // set the owning side to null (unless already changed)
            if ($redSocial->getClient() === $this) {
                $redSocial->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FlightReservation[]
     */
    public function getFlightReservations(): Collection
    {
        return $this->flightReservations;
    }

    public function addFlightReservation(FlightReservation $flightReservation): self
    {
        if (!$this->flightReservations->contains($flightReservation)) {
            $this->flightReservations[] = $flightReservation;
            $flightReservation->setClientProfile($this);
        }

        return $this;
    }

    public function removeFlightReservation(FlightReservation $flightReservation): self
    {
        if ($this->flightReservations->contains($flightReservation)) {
            $this->flightReservations->removeElement($flightReservation);
            // set the owning side to null (unless already changed)
            if ($flightReservation->getClientProfile() === $this) {
                $flightReservation->setClientProfile(null);
            }
        }

        return $this;
    }

}
