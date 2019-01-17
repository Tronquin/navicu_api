<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DailyPriceUpselling
 *
 * @ORM\Table(name="daily_price_upselling", indexes={@ORM\Index(name="IDX_14D1C66318E5767C", columns={"currency_type_id"})})
 * @ORM\Entity
 */
class DailyPriceUpselling
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="daily_price_upselling_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="daily_upselling_id", type="integer", nullable=true)
     */
    private $dailyUpsellingId;

    /**
     * @var float|null
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var \CurrencyType
     *
     * @ORM\ManyToOne(targetEntity="CurrencyType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="currency_type_id", referencedColumnName="id")
     * })
     */
    private $currencyType;


}
