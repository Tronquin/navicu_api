<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UpsellingSpecialPack
 *
 * @ORM\Table(name="upselling_special_pack", indexes={@ORM\Index(name="IDX_EA28C8D4C115EE82", columns={"special_pack_id"}), @ORM\Index(name="IDX_EA28C8D4CFCE4F4B", columns={"upselling_id"})})
 * @ORM\Entity
 */
class UpsellingSpecialPack
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="upselling_special_pack_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="mandatory", type="boolean", nullable=true)
     */
    private $mandatory;

    /**
     * @var float|null
     *
     * @ORM\Column(name="percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $percentage;

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
     * @var \Upselling
     *
     * @ORM\ManyToOne(targetEntity="Upselling")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="upselling_id", referencedColumnName="id")
     * })
     */
    private $upselling;


}
