<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyPack
 *
 * @ORM\Table(name="daily_pack", indexes={@ORM\Index(name="IDX_D3D841B6A4834927", columns={"rule_room_id"}), @ORM\Index(name="IDX_D3D841B68BF6A167", columns={"daily_room_id"})})
 * @ORM\Entity
 */
class DailyPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="daily_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_completed", type="boolean", nullable=false)
     */
    private $isCompleted;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min_night", type="integer", nullable=true)
     */
    private $minNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_night", type="integer", nullable=true)
     */
    private $maxNight;

    /**
     * @var int|null
     *
     * @ORM\Column(name="specific_availability", type="integer", nullable=true)
     */
    private $specificAvailability;

    /**
     * @var float|null
     *
     * @ORM\Column(name="base_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $baseRate;

    /**
     * @var float|null
     *
     * @ORM\Column(name="sell_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $sellRate;

    /**
     * @var float|null
     *
     * @ORM\Column(name="net_rate", type="float", precision=10, scale=0, nullable=true)
     */
    private $netRate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="close_out", type="boolean", nullable=true)
     */
    private $closeOut;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="closed_to_arrival", type="boolean", nullable=true)
     */
    private $closedToArrival;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="closed_to_departure", type="boolean", nullable=true)
     */
    private $closedToDeparture;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_modified", type="datetime", nullable=true)
     */
    private $lastModified;

    /**
     * @var bool
     *
     * @ORM\Column(name="promotion", type="boolean", nullable=false)
     */
    private $promotion = false;

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
     * @var \DailyRoom
     *
     * @ORM\ManyToOne(targetEntity="DailyRoom")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="daily_room_id", referencedColumnName="id")
     * })
     */
    private $dailyRoom;


}
