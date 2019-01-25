<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlightInvoiceLines
 *
 * @ORM\Table(name="flight_invoice_lines", indexes={@ORM\Index(name="idx_a94acf2b2eef49d4", columns={"id_flight_invoice"}), @ORM\Index(name="idx_a94acf2be46053e3", columns={"id_flight"})})
 * @ORM\Entity
 */
class FlightInvoiceLines
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="flight_invoice_lines_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var \Flight
     *
     * @ORM\ManyToOne(targetEntity="Flight")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_flight", referencedColumnName="id")
     * })
     */
    private $idFlight;

    /**
     * @var \FlightInvoice
     *
     * @ORM\ManyToOne(targetEntity="FlightInvoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_flight_invoice", referencedColumnName="id")
     * })
     */
    private $idFlightInvoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIdFlight(): ?Flight
    {
        return $this->idFlight;
    }

    public function setIdFlight(?Flight $idFlight): self
    {
        $this->idFlight = $idFlight;

        return $this;
    }

    public function getIdFlightInvoice(): ?FlightInvoice
    {
        return $this->idFlightInvoice;
    }

    public function setIdFlightInvoice(?FlightInvoice $idFlightInvoice): self
    {
        $this->idFlightInvoice = $idFlightInvoice;

        return $this;
    }


}
