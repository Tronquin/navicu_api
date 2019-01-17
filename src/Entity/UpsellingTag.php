<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UpsellingTag
 *
 * @ORM\Table(name="upselling_tag", indexes={@ORM\Index(name="IDX_899C8947CFCE4F4B", columns={"upselling_id"}), @ORM\Index(name="IDX_899C8947BAD26311", columns={"tag_id"})})
 * @ORM\Entity
 */
class UpsellingTag
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="upselling_tag_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \Upselling
     *
     * @ORM\ManyToOne(targetEntity="Upselling")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="upselling_id", referencedColumnName="id")
     * })
     */
    private $upselling;

    /**
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     * })
     */
    private $tag;


}
