<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table(name="property", uniqueConstraints={@ORM\UniqueConstraint(name="unique_slug_property", columns={"slug"}), @ORM\UniqueConstraint(name="uniq_8bf21cde32e99b8d", columns={"profile_image"}), @ORM\UniqueConstraint(name="uniq_8bf21cde981d9d7f", columns={"base_policy"}), @ORM\UniqueConstraint(name="unique_public_id", columns={"public_id"})}, indexes={@ORM\Index(name="idx_8bf21cde2d385412", columns={"accommodation"}), @ORM\Index(name="idx_8bf21cde38248176", columns={"currency_id"}), @ORM\Index(name="idx_8bf21cde1716ede3", columns={"nvc_profile_id"}), @ORM\Index(name="idx_8bf21cde5e9e89cb", columns={"location"}), @ORM\Index(name="idx_8bf21cdedb8f0c9b", columns={"city_tax_currency_id"}), @ORM\Index(name="idx_8bf21cde7854071c", columns={"commercial_id"}), @ORM\Index(name="idx_8bf21cde90c13dc5", columns={"recruit_id"}), @ORM\Index(name="IDX_8BF21CDE63905048", columns={"opt_profile"})})
 * @ORM\Entity
 */
class Property
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=false)
     */
    private $publicId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hotel_chain_name", type="string", length=255, nullable=true)
     */
    private $hotelChainName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var int
     *
     * @ORM\Column(name="star", type="integer", nullable=false)
     */
    private $star;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url_web", type="string", length=255, nullable=true)
     */
    private $urlWeb;

    /**
     * @var int
     *
     * @ORM\Column(name="amount_room", type="integer", nullable=false)
     */
    private $amountRoom;

    /**
     * @var int
     *
     * @ORM\Column(name="number_floor", type="integer", nullable=false)
     */
    private $numberFloor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_in", type="time", nullable=false)
     */
    private $checkIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_out", type="time", nullable=false)
     */
    private $checkOut;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var array
     *
     * @ORM\Column(name="phones", type="array", nullable=false)
     */
    private $phones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fax", type="string", length=15, nullable=true)
     */
    private $fax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="emails", type="string", length=255, nullable=true)
     */
    private $emails;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rating", type="float", precision=10, scale=0, nullable=true)
     */
    private $rating;

    /**
     * @var float|null
     *
     * @ORM\Column(name="discount_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $discountRate;

    /**
     * @var int
     *
     * @ORM\Column(name="opening_year", type="integer", nullable=false)
     */
    private $openingYear;

    /**
     * @var int|null
     *
     * @ORM\Column(name="renewal_year", type="integer", nullable=true)
     */
    private $renewalYear;

    /**
     * @var int|null
     *
     * @ORM\Column(name="public_areas_renewal_year", type="integer", nullable=true)
     */
    private $publicAreasRenewalYear;

    /**
     * @var int
     *
     * @ORM\Column(name="check_in_age", type="integer", nullable=false)
     */
    private $checkInAge;

    /**
     * @var int|null
     *
     * @ORM\Column(name="child_max_age", type="integer", nullable=true)
     */
    private $childMaxAge;

    /**
     * @var float|null
     *
     * @ORM\Column(name="tax_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $taxRate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="additional_info", type="text", nullable=true)
     */
    private $additionalInfo;

    /**
     * @var array
     *
     * @ORM\Column(name="coordinates", type="json_array", nullable=false)
     */
    private $coordinates;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="beds", type="boolean", nullable=true)
     */
    private $beds;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="beds_additional_cost", type="boolean", nullable=true)
     */
    private $bedsAdditionalCost;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="child", type="boolean", nullable=true)
     */
    private $child;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="cribs_additional_cost", type="boolean", nullable=true)
     */
    private $cribsAdditionalCost;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cribs_max", type="integer", nullable=true)
     */
    private $cribsMax;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="cribs", type="boolean", nullable=true)
     */
    private $cribs;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="pets", type="boolean", nullable=true)
     */
    private $pets;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="pets_additional_cost", type="boolean", nullable=true)
     */
    private $petsAdditionalCost;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="cash", type="boolean", nullable=true)
     */
    private $cash;

    /**
     * @var float|null
     *
     * @ORM\Column(name="max_cash", type="float", precision=10, scale=0, nullable=true)
     */
    private $maxCash;

    /**
     * @var float|null
     *
     * @ORM\Column(name="city_tax", type="float", precision=10, scale=0, nullable=true)
     */
    private $cityTax;

    /**
     * @var int|null
     *
     * @ORM\Column(name="city_tax_type", type="integer", nullable=true)
     */
    private $cityTaxType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="city_tax_max_nights", type="integer", nullable=true)
     */
    private $cityTaxMaxNights;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="credit_card", type="boolean", nullable=true)
     */
    private $creditCard;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="credit_card_amex", type="boolean", nullable=true)
     */
    private $creditCardAmex;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="credit_card_mc", type="boolean", nullable=true)
     */
    private $creditCardMc;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="credit_card_visa", type="boolean", nullable=true)
     */
    private $creditCardVisa;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="all_included", type="boolean", nullable=true)
     */
    private $allIncluded;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="debit", type="boolean", nullable=true)
     */
    private $debit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="comercial_rooms", type="integer", nullable=true)
     */
    private $comercialRooms;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="tax", type="boolean", nullable=true)
     */
    private $tax;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="prominent", type="boolean", nullable=true)
     */
    private $prominent;

    /**
     * @var int
     *
     * @ORM\Column(name="rate_type", type="integer", nullable=false, options={"default"="2"})
     */
    private $rateType = '2';

    /**
     * @var bool|null
     *
     * @ORM\Column(name="beds_prior_notice", type="boolean", nullable=true)
     */
    private $bedsPriorNotice;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="cribs_prior_notice", type="boolean", nullable=true)
     */
    private $cribsPriorNotice;

    /**
     * @var int
     *
     * @ORM\Column(name="basic_quota", type="integer", nullable=false, options={"default"="1"})
     */
    private $basicQuota = '1';

    /**
     * @var int|null
     *
     * @ORM\Column(name="adult_age", type="integer", nullable=true)
     */
    private $adultAge;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="join_date", type="datetime", nullable=true)
     */
    private $joinDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="registration_date", type="datetime", nullable=true)
     */
    private $registrationDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="design_view_property", type="integer", nullable=true, options={"default"="1"})
     */
    private $designViewProperty = '1';

    /**
     * @var array|null
     *
     * @ORM\Column(name="age_policy", type="json_array", nullable=true)
     */
    private $agePolicy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="unpublished_date", type="datetime", nullable=true)
     */
    private $unpublishedDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="featured_home", type="boolean", nullable=false)
     */
    private $featuredHome = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="promo_home", type="boolean", nullable=false)
     */
    private $promoHome = false;

    /**
     * @var string|null
     *
     * @ORM\Column(name="featured_location", type="string", length=255, nullable=true)
     */
    private $featuredLocation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_folder_id", type="string", nullable=true)
     */
    private $imageFolderId;

    /**
     * @var bool
     *
     * @ORM\Column(name="b2c", type="boolean", nullable=false, options={"default"="1"})
     */
    private $b2c = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="b2b", type="boolean", nullable=false)
     */
    private $b2b = false;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="remove", type="boolean", nullable=true)
     */
    private $remove = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="pay_in_bs", type="boolean", nullable=false, options={"default"="1"})
     */
    private $payInBs = true;

    /**
     * @var float
     *
     * @ORM\Column(name="discount_rate_by_foreing_currency", type="float", precision=10, scale=0, nullable=false)
     */
    private $discountRateByForeingCurrency = '0';

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
     * @var \Accommodation
     *
     * @ORM\ManyToOne(targetEntity="Accommodation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="accommodation", referencedColumnName="id")
     * })
     */
    private $accommodation;

    /**
     * @var \PropertyFavoriteImages
     *
     * @ORM\ManyToOne(targetEntity="PropertyFavoriteImages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_image", referencedColumnName="id")
     * })
     */
    private $profileImage;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     * })
     */
    private $currency;

    /**
     * @var \Location
     *
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="location", referencedColumnName="id")
     * })
     */
    private $location;

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
     * @var \NvcProfile
     *
     * @ORM\ManyToOne(targetEntity="NvcProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="opt_profile", referencedColumnName="id")
     * })
     */
    private $optProfile;

    /**
     * @var \PropertyCancellationPolicy
     *
     * @ORM\ManyToOne(targetEntity="PropertyCancellationPolicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="base_policy", referencedColumnName="id")
     * })
     */
    private $basePolicy;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_tax_currency_id", referencedColumnName="id")
     * })
     */
    private $cityTaxCurrency;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Language", inversedBy="property")
     * @ORM\JoinTable(name="property_language",
     *   joinColumns={
     *     @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     *   }
     * )
     */
    private $language;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="OwnerProfile", mappedBy="property")
     */
    private $ownerprofile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->language = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ownerprofile = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    public function setPublicId(string $publicId): self
    {
        $this->publicId = $publicId;

        return $this;
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getHotelChainName(): ?string
    {
        return $this->hotelChainName;
    }

    public function setHotelChainName(?string $hotelChainName): self
    {
        $this->hotelChainName = $hotelChainName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getStar(): ?int
    {
        return $this->star;
    }

    public function setStar(int $star): self
    {
        $this->star = $star;

        return $this;
    }

    public function getUrlWeb(): ?string
    {
        return $this->urlWeb;
    }

    public function setUrlWeb(?string $urlWeb): self
    {
        $this->urlWeb = $urlWeb;

        return $this;
    }

    public function getAmountRoom(): ?int
    {
        return $this->amountRoom;
    }

    public function setAmountRoom(int $amountRoom): self
    {
        $this->amountRoom = $amountRoom;

        return $this;
    }

    public function getNumberFloor(): ?int
    {
        return $this->numberFloor;
    }

    public function setNumberFloor(int $numberFloor): self
    {
        $this->numberFloor = $numberFloor;

        return $this;
    }

    public function getCheckIn(): ?\DateTimeInterface
    {
        return $this->checkIn;
    }

    public function setCheckIn(\DateTimeInterface $checkIn): self
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    public function getCheckOut(): ?\DateTimeInterface
    {
        return $this->checkOut;
    }

    public function setCheckOut(\DateTimeInterface $checkOut): self
    {
        $this->checkOut = $checkOut;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhones(): ?array
    {
        return $this->phones;
    }

    public function setPhones(array $phones): self
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

    public function getEmails(): ?string
    {
        return $this->emails;
    }

    public function setEmails(?string $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDiscountRate(): ?float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(?float $discountRate): self
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    public function getOpeningYear(): ?int
    {
        return $this->openingYear;
    }

    public function setOpeningYear(int $openingYear): self
    {
        $this->openingYear = $openingYear;

        return $this;
    }

    public function getRenewalYear(): ?int
    {
        return $this->renewalYear;
    }

    public function setRenewalYear(?int $renewalYear): self
    {
        $this->renewalYear = $renewalYear;

        return $this;
    }

    public function getPublicAreasRenewalYear(): ?int
    {
        return $this->publicAreasRenewalYear;
    }

    public function setPublicAreasRenewalYear(?int $publicAreasRenewalYear): self
    {
        $this->publicAreasRenewalYear = $publicAreasRenewalYear;

        return $this;
    }

    public function getCheckInAge(): ?int
    {
        return $this->checkInAge;
    }

    public function setCheckInAge(int $checkInAge): self
    {
        $this->checkInAge = $checkInAge;

        return $this;
    }

    public function getChildMaxAge(): ?int
    {
        return $this->childMaxAge;
    }

    public function setChildMaxAge(?int $childMaxAge): self
    {
        $this->childMaxAge = $childMaxAge;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    public function setTaxRate(?float $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function getBeds(): ?bool
    {
        return $this->beds;
    }

    public function setBeds(?bool $beds): self
    {
        $this->beds = $beds;

        return $this;
    }

    public function getBedsAdditionalCost(): ?bool
    {
        return $this->bedsAdditionalCost;
    }

    public function setBedsAdditionalCost(?bool $bedsAdditionalCost): self
    {
        $this->bedsAdditionalCost = $bedsAdditionalCost;

        return $this;
    }

    public function getChild(): ?bool
    {
        return $this->child;
    }

    public function setChild(?bool $child): self
    {
        $this->child = $child;

        return $this;
    }

    public function getCribsAdditionalCost(): ?bool
    {
        return $this->cribsAdditionalCost;
    }

    public function setCribsAdditionalCost(?bool $cribsAdditionalCost): self
    {
        $this->cribsAdditionalCost = $cribsAdditionalCost;

        return $this;
    }

    public function getCribsMax(): ?int
    {
        return $this->cribsMax;
    }

    public function setCribsMax(?int $cribsMax): self
    {
        $this->cribsMax = $cribsMax;

        return $this;
    }

    public function getCribs(): ?bool
    {
        return $this->cribs;
    }

    public function setCribs(?bool $cribs): self
    {
        $this->cribs = $cribs;

        return $this;
    }

    public function getPets(): ?bool
    {
        return $this->pets;
    }

    public function setPets(?bool $pets): self
    {
        $this->pets = $pets;

        return $this;
    }

    public function getPetsAdditionalCost(): ?bool
    {
        return $this->petsAdditionalCost;
    }

    public function setPetsAdditionalCost(?bool $petsAdditionalCost): self
    {
        $this->petsAdditionalCost = $petsAdditionalCost;

        return $this;
    }

    public function getCash(): ?bool
    {
        return $this->cash;
    }

    public function setCash(?bool $cash): self
    {
        $this->cash = $cash;

        return $this;
    }

    public function getMaxCash(): ?float
    {
        return $this->maxCash;
    }

    public function setMaxCash(?float $maxCash): self
    {
        $this->maxCash = $maxCash;

        return $this;
    }

    public function getCityTax(): ?float
    {
        return $this->cityTax;
    }

    public function setCityTax(?float $cityTax): self
    {
        $this->cityTax = $cityTax;

        return $this;
    }

    public function getCityTaxType(): ?int
    {
        return $this->cityTaxType;
    }

    public function setCityTaxType(?int $cityTaxType): self
    {
        $this->cityTaxType = $cityTaxType;

        return $this;
    }

    public function getCityTaxMaxNights(): ?int
    {
        return $this->cityTaxMaxNights;
    }

    public function setCityTaxMaxNights(?int $cityTaxMaxNights): self
    {
        $this->cityTaxMaxNights = $cityTaxMaxNights;

        return $this;
    }

    public function getCreditCard(): ?bool
    {
        return $this->creditCard;
    }

    public function setCreditCard(?bool $creditCard): self
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    public function getCreditCardAmex(): ?bool
    {
        return $this->creditCardAmex;
    }

    public function setCreditCardAmex(?bool $creditCardAmex): self
    {
        $this->creditCardAmex = $creditCardAmex;

        return $this;
    }

    public function getCreditCardMc(): ?bool
    {
        return $this->creditCardMc;
    }

    public function setCreditCardMc(?bool $creditCardMc): self
    {
        $this->creditCardMc = $creditCardMc;

        return $this;
    }

    public function getCreditCardVisa(): ?bool
    {
        return $this->creditCardVisa;
    }

    public function setCreditCardVisa(?bool $creditCardVisa): self
    {
        $this->creditCardVisa = $creditCardVisa;

        return $this;
    }

    public function getAllIncluded(): ?bool
    {
        return $this->allIncluded;
    }

    public function setAllIncluded(?bool $allIncluded): self
    {
        $this->allIncluded = $allIncluded;

        return $this;
    }

    public function getDebit(): ?bool
    {
        return $this->debit;
    }

    public function setDebit(?bool $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    public function getComercialRooms(): ?int
    {
        return $this->comercialRooms;
    }

    public function setComercialRooms(?int $comercialRooms): self
    {
        $this->comercialRooms = $comercialRooms;

        return $this;
    }

    public function getTax(): ?bool
    {
        return $this->tax;
    }

    public function setTax(?bool $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getProminent(): ?bool
    {
        return $this->prominent;
    }

    public function setProminent(?bool $prominent): self
    {
        $this->prominent = $prominent;

        return $this;
    }

    public function getRateType(): ?int
    {
        return $this->rateType;
    }

    public function setRateType(int $rateType): self
    {
        $this->rateType = $rateType;

        return $this;
    }

    public function getBedsPriorNotice(): ?bool
    {
        return $this->bedsPriorNotice;
    }

    public function setBedsPriorNotice(?bool $bedsPriorNotice): self
    {
        $this->bedsPriorNotice = $bedsPriorNotice;

        return $this;
    }

    public function getCribsPriorNotice(): ?bool
    {
        return $this->cribsPriorNotice;
    }

    public function setCribsPriorNotice(?bool $cribsPriorNotice): self
    {
        $this->cribsPriorNotice = $cribsPriorNotice;

        return $this;
    }

    public function getBasicQuota(): ?int
    {
        return $this->basicQuota;
    }

    public function setBasicQuota(int $basicQuota): self
    {
        $this->basicQuota = $basicQuota;

        return $this;
    }

    public function getAdultAge(): ?int
    {
        return $this->adultAge;
    }

    public function setAdultAge(?int $adultAge): self
    {
        $this->adultAge = $adultAge;

        return $this;
    }

    public function getJoinDate(): ?\DateTimeInterface
    {
        return $this->joinDate;
    }

    public function setJoinDate(?\DateTimeInterface $joinDate): self
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(?\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getDesignViewProperty(): ?int
    {
        return $this->designViewProperty;
    }

    public function setDesignViewProperty(?int $designViewProperty): self
    {
        $this->designViewProperty = $designViewProperty;

        return $this;
    }

    public function getAgePolicy()
    {
        return $this->agePolicy;
    }

    public function setAgePolicy($agePolicy): self
    {
        $this->agePolicy = $agePolicy;

        return $this;
    }

    public function getUnpublishedDate(): ?\DateTimeInterface
    {
        return $this->unpublishedDate;
    }

    public function setUnpublishedDate(?\DateTimeInterface $unpublishedDate): self
    {
        $this->unpublishedDate = $unpublishedDate;

        return $this;
    }

    public function getFeaturedHome(): ?bool
    {
        return $this->featuredHome;
    }

    public function setFeaturedHome(bool $featuredHome): self
    {
        $this->featuredHome = $featuredHome;

        return $this;
    }

    public function getPromoHome(): ?bool
    {
        return $this->promoHome;
    }

    public function setPromoHome(bool $promoHome): self
    {
        $this->promoHome = $promoHome;

        return $this;
    }

    public function getFeaturedLocation(): ?string
    {
        return $this->featuredLocation;
    }

    public function setFeaturedLocation(?string $featuredLocation): self
    {
        $this->featuredLocation = $featuredLocation;

        return $this;
    }

    public function getImageFolderId(): ?string
    {
        return $this->imageFolderId;
    }

    public function setImageFolderId(?string $imageFolderId): self
    {
        $this->imageFolderId = $imageFolderId;

        return $this;
    }

    public function getB2c(): ?bool
    {
        return $this->b2c;
    }

    public function setB2c(bool $b2c): self
    {
        $this->b2c = $b2c;

        return $this;
    }

    public function getB2b(): ?bool
    {
        return $this->b2b;
    }

    public function setB2b(bool $b2b): self
    {
        $this->b2b = $b2b;

        return $this;
    }

    public function getRemove(): ?bool
    {
        return $this->remove;
    }

    public function setRemove(?bool $remove): self
    {
        $this->remove = $remove;

        return $this;
    }

    public function getPayInBs(): ?bool
    {
        return $this->payInBs;
    }

    public function setPayInBs(bool $payInBs): self
    {
        $this->payInBs = $payInBs;

        return $this;
    }

    public function getDiscountRateByForeingCurrency(): ?float
    {
        return $this->discountRateByForeingCurrency;
    }

    public function setDiscountRateByForeingCurrency(float $discountRateByForeingCurrency): self
    {
        $this->discountRateByForeingCurrency = $discountRateByForeingCurrency;

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

    public function getAccommodation(): ?Accommodation
    {
        return $this->accommodation;
    }

    public function setAccommodation(?Accommodation $accommodation): self
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    public function getProfileImage(): ?PropertyFavoriteImages
    {
        return $this->profileImage;
    }

    public function setProfileImage(?PropertyFavoriteImages $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    public function getCurrency(): ?CurrencyType
    {
        return $this->currency;
    }

    public function setCurrency(?CurrencyType $currency): self
    {
        $this->currency = $currency;

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

    public function getOptProfile(): ?NvcProfile
    {
        return $this->optProfile;
    }

    public function setOptProfile(?NvcProfile $optProfile): self
    {
        $this->optProfile = $optProfile;

        return $this;
    }

    public function getBasePolicy(): ?PropertyCancellationPolicy
    {
        return $this->basePolicy;
    }

    public function setBasePolicy(?PropertyCancellationPolicy $basePolicy): self
    {
        $this->basePolicy = $basePolicy;

        return $this;
    }

    public function getCityTaxCurrency(): ?CurrencyType
    {
        return $this->cityTaxCurrency;
    }

    public function setCityTaxCurrency(?CurrencyType $cityTaxCurrency): self
    {
        $this->cityTaxCurrency = $cityTaxCurrency;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguage(): Collection
    {
        return $this->language;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->language->contains($language)) {
            $this->language[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        if ($this->language->contains($language)) {
            $this->language->removeElement($language);
        }

        return $this;
    }

    /**
     * @return Collection|OwnerProfile[]
     */
    public function getOwnerprofile(): Collection
    {
        return $this->ownerprofile;
    }

    public function addOwnerprofile(OwnerProfile $ownerprofile): self
    {
        if (!$this->ownerprofile->contains($ownerprofile)) {
            $this->ownerprofile[] = $ownerprofile;
            $ownerprofile->addProperty($this);
        }

        return $this;
    }

    public function removeOwnerprofile(OwnerProfile $ownerprofile): self
    {
        if ($this->ownerprofile->contains($ownerprofile)) {
            $this->ownerprofile->removeElement($ownerprofile);
            $ownerprofile->removeProperty($this);
        }

        return $this;
    }

}
