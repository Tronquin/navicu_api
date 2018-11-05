<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tempowner
 *
 * @ORM\Table(name="tempowner", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_3b4c192da76ed395", columns={"user_id"}), @ORM\UniqueConstraint(name="unique_slug", columns={"slug"})}, indexes={@ORM\Index(name="idx_3b4c192d90c13dc5", columns={"recruit_id"}), @ORM\Index(name="idx_3b4c192d7854071c", columns={"commercial_id"}), @ORM\Index(name="idx_3b4c192d1716ede3", columns={"nvc_profile_id"}), @ORM\Index(name="IDX_3B4C192D63905048", columns={"opt_profile"})})
 * @ORM\Entity
 */
class Tempowner
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tempowner_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="lastsec", type="integer", nullable=false)
     */
    private $lastsec;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiredate", type="datetime", nullable=false)
     */
    private $expiredate;

    /**
     * @var array|null
     *
     * @ORM\Column(name="propertyform", type="json_array", nullable=true)
     */
    private $propertyform;

    /**
     * @var array|null
     *
     * @ORM\Column(name="services_form", type="json_array", nullable=true)
     */
    private $servicesForm;

    /**
     * @var array|null
     *
     * @ORM\Column(name="rooms_form", type="json_array", nullable=true)
     */
    private $roomsForm;

    /**
     * @var array|null
     *
     * @ORM\Column(name="payment_info_form", type="json_array", nullable=true)
     */
    private $paymentInfoForm;

    /**
     * @var array|null
     *
     * @ORM\Column(name="terms_and_conditions_info", type="json_array", nullable=true)
     */
    private $termsAndConditionsInfo;

    /**
     * @var array|null
     *
     * @ORM\Column(name="gallery_form", type="json_array", nullable=true)
     */
    private $galleryForm;

    /**
     * @var array|null
     *
     * @ORM\Column(name="validations", type="json_array", nullable=true)
     */
    private $validations;

    /**
     * @var array
     *
     * @ORM\Column(name="progress", type="json_array", nullable=false, options={"default"="[]"})
     */
    private $progress = '[]';

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nvc_profile_id", referencedColumnName="id")
     * })
     */
    private $nvcProfile;

    /**
     * @var \CommercialProfile
     *
     * @ORM\ManyToOne(targetEntity="CommercialProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="commercial_id", referencedColumnName="id")
     * })
     */
    private $commercial;

    /**
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recruit_id", referencedColumnName="id")
     * })
     */
    private $recruit;

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
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="opt_profile", referencedColumnName="id")
     * })
     */
    private $optProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastsec(): ?int
    {
        return $this->lastsec;
    }

    public function setLastsec(int $lastsec): self
    {
        $this->lastsec = $lastsec;

        return $this;
    }

    public function getExpiredate(): ?\DateTimeInterface
    {
        return $this->expiredate;
    }

    public function setExpiredate(\DateTimeInterface $expiredate): self
    {
        $this->expiredate = $expiredate;

        return $this;
    }

    public function getPropertyform()
    {
        return $this->propertyform;
    }

    public function setPropertyform($propertyform): self
    {
        $this->propertyform = $propertyform;

        return $this;
    }

    public function getServicesForm()
    {
        return $this->servicesForm;
    }

    public function setServicesForm($servicesForm): self
    {
        $this->servicesForm = $servicesForm;

        return $this;
    }

    public function getRoomsForm()
    {
        return $this->roomsForm;
    }

    public function setRoomsForm($roomsForm): self
    {
        $this->roomsForm = $roomsForm;

        return $this;
    }

    public function getPaymentInfoForm()
    {
        return $this->paymentInfoForm;
    }

    public function setPaymentInfoForm($paymentInfoForm): self
    {
        $this->paymentInfoForm = $paymentInfoForm;

        return $this;
    }

    public function getTermsAndConditionsInfo()
    {
        return $this->termsAndConditionsInfo;
    }

    public function setTermsAndConditionsInfo($termsAndConditionsInfo): self
    {
        $this->termsAndConditionsInfo = $termsAndConditionsInfo;

        return $this;
    }

    public function getGalleryForm()
    {
        return $this->galleryForm;
    }

    public function setGalleryForm($galleryForm): self
    {
        $this->galleryForm = $galleryForm;

        return $this;
    }

    public function getValidations()
    {
        return $this->validations;
    }

    public function setValidations($validations): self
    {
        $this->validations = $validations;

        return $this;
    }

    public function getProgress()
    {
        return $this->progress;
    }

    public function setProgress($progress): self
    {
        $this->progress = $progress;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

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

    public function getCommercial(): ?CommercialProfile
    {
        return $this->commercial;
    }

    public function setCommercial(?CommercialProfile $commercial): self
    {
        $this->commercial = $commercial;

        return $this;
    }

    public function getRecruit(): ?NvcProfile
    {
        return $this->recruit;
    }

    public function setRecruit(?NvcProfile $recruit): self
    {
        $this->recruit = $recruit;

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

    public function getOptProfile(): ?NvcProfile
    {
        return $this->optProfile;
    }

    public function setOptProfile(?NvcProfile $optProfile): self
    {
        $this->optProfile = $optProfile;

        return $this;
    }


}
