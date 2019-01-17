<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialOffer
 *
 * @ORM\Table(name="special_offer", indexes={@ORM\Index(name="IDX_85E8297F9E395312", columns={"type_offer_id"})})
 * @ORM\Entity
 */
class SpecialOffer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="special_offer_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var float|null
     *
     * @ORM\Column(name="percentaje", type="float", precision=10, scale=0, nullable=true)
     */
    private $percentaje;

    /**
     * @var string|null
     *
     * @ORM\Column(name="promotional_code", type="string", length=255, nullable=true)
     */
    private $promotionalCode;

    /**
     * @var int|null
     *
     * @ORM\Column(name="min_nights", type="integer", nullable=true)
     */
    private $minNights;

    /**
     * @var int|null
     *
     * @ORM\Column(name="max_nights", type="integer", nullable=true)
     */
    private $maxNights;

    /**
     * @var int|null
     *
     * @ORM\Column(name="free_nights", type="integer", nullable=true)
     */
    private $freeNights;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ini_date", type="date", nullable=true)
     */
    private $iniDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

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
     * @var string|null
     *
     * @ORM\Column(name="valid_days", type="text", nullable=true)
     */
    private $validDays;

    /**
     * @var int|null
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var \TypeOffer
     *
     * @ORM\ManyToOne(targetEntity="TypeOffer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_offer_id", referencedColumnName="id")
     * })
     */
    private $typeOffer;


}
