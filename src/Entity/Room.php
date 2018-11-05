<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table(name="room", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_729f519b989d9b62", columns={"slug"}), @ORM\UniqueConstraint(name="uniq_729f519b32e99b8d", columns={"profile_image"})}, indexes={@ORM\Index(name="idx_729f519b549213ec", columns={"property_id"}), @ORM\Index(name="idx_729f519bc54c8c93", columns={"type_id"})})
 * @ORM\Entity
 */
class Room
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="room_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float|null
     *
     * @ORM\Column(name="low_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $lowRate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="base_availability", type="integer", nullable=true)
     */
    private $baseAvailability;

    /**
     * @var int
     *
     * @ORM\Column(name="min_people", type="integer", nullable=false)
     */
    private $minPeople;

    /**
     * @var int
     *
     * @ORM\Column(name="max_people", type="integer", nullable=false)
     */
    private $maxPeople;

    /**
     * @var int
     *
     * @ORM\Column(name="variation_type_people", type="integer", nullable=false)
     */
    private $variationTypePeople;

    /**
     * @var int
     *
     * @ORM\Column(name="amount_rooms", type="integer", nullable=false)
     */
    private $amountRooms;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="smoking_policy", type="boolean", nullable=true)
     */
    private $smokingPolicy;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float|null
     *
     * @ORM\Column(name="size", type="float", precision=10, scale=0, nullable=true)
     */
    private $size;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="increment", type="boolean", nullable=true)
     */
    private $increment;

    /**
     * @var array|null
     *
     * @ORM\Column(name="variation_type_kids", type="json_array", nullable=true)
     */
    private $variationTypeKids;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isActive = true;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="increment_kid", type="boolean", nullable=true)
     */
    private $incrementKid = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="kid_pay_as_adult", type="boolean", nullable=false, options={"default"="1"})
     */
    private $kidPayAsAdult = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="same_increment_adult", type="boolean", nullable=false, options={"default"="1"})
     */
    private $sameIncrementAdult = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="same_increment_kid", type="boolean", nullable=false, options={"default"="1"})
     */
    private $sameIncrementKid = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_folder_id", type="string", nullable=true)
     */
    private $imageFolderId;

    /**
     * @var \RoomImagesGallery
     *
     * @ORM\ManyToOne(targetEntity="RoomImagesGallery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profile_image", referencedColumnName="id")
     * })
     */
    private $profileImage;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;

    /**
     * @var \RoomType
     *
     * @ORM\ManyToOne(targetEntity="RoomType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLowRate(): ?float
    {
        return $this->lowRate;
    }

    public function setLowRate(?float $lowRate): self
    {
        $this->lowRate = $lowRate;

        return $this;
    }

    public function getBaseAvailability(): ?int
    {
        return $this->baseAvailability;
    }

    public function setBaseAvailability(?int $baseAvailability): self
    {
        $this->baseAvailability = $baseAvailability;

        return $this;
    }

    public function getMinPeople(): ?int
    {
        return $this->minPeople;
    }

    public function setMinPeople(int $minPeople): self
    {
        $this->minPeople = $minPeople;

        return $this;
    }

    public function getMaxPeople(): ?int
    {
        return $this->maxPeople;
    }

    public function setMaxPeople(int $maxPeople): self
    {
        $this->maxPeople = $maxPeople;

        return $this;
    }

    public function getVariationTypePeople(): ?int
    {
        return $this->variationTypePeople;
    }

    public function setVariationTypePeople(int $variationTypePeople): self
    {
        $this->variationTypePeople = $variationTypePeople;

        return $this;
    }

    public function getAmountRooms(): ?int
    {
        return $this->amountRooms;
    }

    public function setAmountRooms(int $amountRooms): self
    {
        $this->amountRooms = $amountRooms;

        return $this;
    }

    public function getSmokingPolicy(): ?bool
    {
        return $this->smokingPolicy;
    }

    public function setSmokingPolicy(?bool $smokingPolicy): self
    {
        $this->smokingPolicy = $smokingPolicy;

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

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getIncrement(): ?bool
    {
        return $this->increment;
    }

    public function setIncrement(?bool $increment): self
    {
        $this->increment = $increment;

        return $this;
    }

    public function getVariationTypeKids()
    {
        return $this->variationTypeKids;
    }

    public function setVariationTypeKids($variationTypeKids): self
    {
        $this->variationTypeKids = $variationTypeKids;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getIncrementKid(): ?bool
    {
        return $this->incrementKid;
    }

    public function setIncrementKid(?bool $incrementKid): self
    {
        $this->incrementKid = $incrementKid;

        return $this;
    }

    public function getKidPayAsAdult(): ?bool
    {
        return $this->kidPayAsAdult;
    }

    public function setKidPayAsAdult(bool $kidPayAsAdult): self
    {
        $this->kidPayAsAdult = $kidPayAsAdult;

        return $this;
    }

    public function getSameIncrementAdult(): ?bool
    {
        return $this->sameIncrementAdult;
    }

    public function setSameIncrementAdult(bool $sameIncrementAdult): self
    {
        $this->sameIncrementAdult = $sameIncrementAdult;

        return $this;
    }

    public function getSameIncrementKid(): ?bool
    {
        return $this->sameIncrementKid;
    }

    public function setSameIncrementKid(bool $sameIncrementKid): self
    {
        $this->sameIncrementKid = $sameIncrementKid;

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

    public function getImageFolderId(): ?string
    {
        return $this->imageFolderId;
    }

    public function setImageFolderId(?string $imageFolderId): self
    {
        $this->imageFolderId = $imageFolderId;

        return $this;
    }

    public function getProfileImage(): ?RoomImagesGallery
    {
        return $this->profileImage;
    }

    public function setProfileImage(?RoomImagesGallery $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getType(): ?RoomType
    {
        return $this->type;
    }

    public function setType(?RoomType $type): self
    {
        $this->type = $type;

        return $this;
    }


}
