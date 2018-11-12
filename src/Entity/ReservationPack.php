<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationPack
 *
 * @ORM\Table(name="reservation_pack", indexes={@ORM\Index(name="idx_81e7934bc54c8c93", columns={"type_cancellation_policy_id"}), @ORM\Index(name="idx_81e7934b1919b217", columns={"pack_id"}), @ORM\Index(name="idx_81e7934b5183b04c", columns={"property_cancellation_policy_id"}), @ORM\Index(name="idx_81e7934b7c361f66", columns={"type_room_id"}), @ORM\Index(name="idx_81e7934bbdb6797c", columns={"bedroom_id"}), @ORM\Index(name="idx_81e7934bb83297e7", columns={"reservation_id"}), @ORM\Index(name="idx_81e7934b3138dde2", columns={"type_pack_id"})})
 * @ORM\Entity
 */
class ReservationPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="reservation_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="number_rooms", type="integer", nullable=false)
     */
    private $numberRooms;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="number_adults", type="integer", nullable=false)
     */
    private $numberAdults;

    /**
     * @var array|null
     *
     * @ORM\Column(name="bedroom", type="json_array", nullable=true)
     */
    private $bedroom;

    /**
     * @var array|null
     *
     * @ORM\Column(name="cancellation_policy", type="json_array", nullable=true)
     */
    private $cancellationPolicy;

    /**
     * @var int
     *
     * @ORM\Column(name="number_kids", type="integer", nullable=false)
     */
    private $numberKids = '0';

    /**
     * @var \Pack
     *
     * @ORM\ManyToOne(targetEntity="Pack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pack_id", referencedColumnName="id")
     * })
     */
    private $pack;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_pack_id", referencedColumnName="id")
     * })
     */
    private $typePack;

    /**
     * @var \PropertyCancellationPolicy
     *
     * @ORM\ManyToOne(targetEntity="PropertyCancellationPolicy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_cancellation_policy_id", referencedColumnName="id")
     * })
     */
    private $propertyCancellationPolicy;

    /**
     * @var \RoomType
     *
     * @ORM\ManyToOne(targetEntity="RoomType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_room_id", referencedColumnName="id")
     * })
     */
    private $typeRoom;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_id", referencedColumnName="id")
     * })
     */
    private $reservation;

    /**
     * @var \Bedroom
     *
     * @ORM\ManyToOne(targetEntity="Bedroom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bedroom_id", referencedColumnName="id")
     * })
     */
    private $bedroom2;

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_cancellation_policy_id", referencedColumnName="id")
     * })
     */
    private $typeCancellationPolicy;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberRooms(): ?int
    {
        return $this->numberRooms;
    }

    public function setNumberRooms(int $numberRooms): self
    {
        $this->numberRooms = $numberRooms;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNumberAdults(): ?int
    {
        return $this->numberAdults;
    }

    public function setNumberAdults(int $numberAdults): self
    {
        $this->numberAdults = $numberAdults;

        return $this;
    }

    public function getBedroom()
    {
        return $this->bedroom;
    }

    public function setBedroom($bedroom): self
    {
        $this->bedroom = $bedroom;

        return $this;
    }

    public function getCancellationPolicy()
    {
        return $this->cancellationPolicy;
    }

    public function setCancellationPolicy($cancellationPolicy): self
    {
        $this->cancellationPolicy = $cancellationPolicy;

        return $this;
    }

    public function getNumberKids(): ?int
    {
        return $this->numberKids;
    }

    public function setNumberKids(int $numberKids): self
    {
        $this->numberKids = $numberKids;

        return $this;
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }

    public function getTypePack(): ?Categories
    {
        return $this->typePack;
    }

    public function setTypePack(?Categories $typePack): self
    {
        $this->typePack = $typePack;

        return $this;
    }

    public function getPropertyCancellationPolicy(): ?PropertyCancellationPolicy
    {
        return $this->propertyCancellationPolicy;
    }

    public function setPropertyCancellationPolicy(?PropertyCancellationPolicy $propertyCancellationPolicy): self
    {
        $this->propertyCancellationPolicy = $propertyCancellationPolicy;

        return $this;
    }

    public function getTypeRoom(): ?RoomType
    {
        return $this->typeRoom;
    }

    public function setTypeRoom(?RoomType $typeRoom): self
    {
        $this->typeRoom = $typeRoom;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getBedroom2(): ?Bedroom
    {
        return $this->bedroom2;
    }

    public function setBedroom2(?Bedroom $bedroom2): self
    {
        $this->bedroom2 = $bedroom2;

        return $this;
    }

    public function getTypeCancellationPolicy(): ?Categories
    {
        return $this->typeCancellationPolicy;
    }

    public function setTypeCancellationPolicy(?Categories $typeCancellationPolicy): self
    {
        $this->typeCancellationPolicy = $typeCancellationPolicy;

        return $this;
    }


}
