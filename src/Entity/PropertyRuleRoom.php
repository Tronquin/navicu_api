<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PropertyRuleRoom
 *
 * @ORM\Table(name="property_rule_room", indexes={@ORM\Index(name="IDX_50B40C51A4834927", columns={"rule_room_id"}), @ORM\Index(name="IDX_50B40C51549213EC", columns={"property_id"})})
 * @ORM\Entity
 */
class PropertyRuleRoom
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="property_rule_room_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     * })
     */
    private $property;


}
