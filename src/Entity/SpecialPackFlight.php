<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialPackFlight
 *
 * @ORM\Table(name="special_pack_flight", indexes={@ORM\Index(name="IDX_2E628086C115EE82", columns={"special_pack_id"}), @ORM\Index(name="IDX_2E6280867522FBAB", columns={"destiny"}), @ORM\Index(name="IDX_2E628086DEF1561E", columns={"origin"}), @ORM\Index(name="IDX_2E628086130D0C16", columns={"airline_id"})})
 * @ORM\Entity
 */
class SpecialPackFlight
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="special_pack_flight_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="class", type="string", length=1, nullable=true, options={"fixed"=true})
     */
    private $class;

    /**
     * @var \SpecialPack
     *
     * @ORM\ManyToOne(targetEntity="SpecialPack")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="special_pack_id", referencedColumnName="id")
     * })
     */
    private $specialPack;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="destiny", referencedColumnName="id")
     * })
     */
    private $destiny;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="origin", referencedColumnName="id")
     * })
     */
    private $origin;

    /**
     * @var \Airline
     *
     * @ORM\ManyToOne(targetEntity="Airline")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airline_id", referencedColumnName="id")
     * })
     */
    private $airline;


}
