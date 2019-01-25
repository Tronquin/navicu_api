<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UpsellingChannel
 *
 * @ORM\Table(name="upselling_channel", indexes={@ORM\Index(name="IDX_4FFBB3A6CFCE4F4B", columns={"upselling_id"}), @ORM\Index(name="IDX_4FFBB3A672F5A1AA", columns={"channel_id"})})
 * @ORM\Entity
 */
class UpsellingChannel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="upselling_channel_id_seq", allocationSize=1, initialValue=1)
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
     * @var \Channel
     *
     * @ORM\ManyToOne(targetEntity="Channel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="channel_id", referencedColumnName="id")
     * })
     */
    private $channel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUpselling(): ?Upselling
    {
        return $this->upselling;
    }

    public function setUpselling(?Upselling $upselling): self
    {
        $this->upselling = $upselling;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }


}
