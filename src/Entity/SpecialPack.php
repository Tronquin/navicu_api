<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialPack
 *
 * @ORM\Table(name="special_pack", indexes={@ORM\Index(name="IDX_15895F08549213EC", columns={"property_id"})})
 * @ORM\Entity
 */
class SpecialPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="special_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string|null
     *
     * @ORM\Column(name="banner_route", type="string", length=255, nullable=true)
     */
    private $bannerRoute;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @var string|null
     *
     * @ORM\Column(name="valid_days", type="text", nullable=true)
     */
    private $validDays;

    /**
     * @var float|null
     *
     * @ORM\Column(name="percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $percentage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;


}
