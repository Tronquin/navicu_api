<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationPack
 *
 * @ORM\Table(name="reservation_pack", indexes={@ORM\Index(name="idx_81e7934b3138dde2", columns={"type_pack_id"}), @ORM\Index(name="idx_81e7934b5183b04c", columns={"property_cancellation_policy_id"}), @ORM\Index(name="idx_81e7934bb83297e7", columns={"reservation_id"}), @ORM\Index(name="idx_81e7934b7c361f66", columns={"type_room_id"}), @ORM\Index(name="idx_81e7934bbdb6797c", columns={"bedroom_id"}), @ORM\Index(name="idx_81e7934bc54c8c93", columns={"type_cancellation_policy_id"}), @ORM\Index(name="IDX_81E7934B54177093", columns={"room_id"}), @ORM\Index(name="IDX_81E7934BA4834927", columns={"rule_room_id"}), @ORM\Index(name="IDX_81E7934BD37B1F79", columns={"special_offer_id"})})
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

    /**
     * @var \Room
     *
     * @ORM\ManyToOne(targetEntity="Room")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     * })
     */
    private $room;

    /**
     * @var \RuleRoom
     *
     * @ORM\ManyToOne(targetEntity="RuleRoom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rule_room_id", referencedColumnName="id")
     * })
     */
    private $ruleRoom;

    /**
     * @var \SpecialOffer
     *
     * @ORM\ManyToOne(targetEntity="SpecialOffer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="special_offer_id", referencedColumnName="id")
     * })
     */
    private $specialOffer;


}
