<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Entity\FlightTicket;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\OtaService;

/**
 * Genera el ticket para una reserva
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class IssueTicketHandler extends BaseHandler
{
    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        foreach ($reservation->getGdsReservations() as $gdsReservation) {

            $currency = $gdsReservation->getCurrencyGds()->getAlfa3();
            $country = $currency === 'USD' ? 'US' : 'VE';

            $response = OtaService::ticket([
                'country' => $country,
                'currency' => $currency,
                'PaymentType' => 1, // Cash Kiu
                'BookingID' => $gdsReservation->getBookCode(),
                'provider' => $gdsReservation->getGds()->getName()
            ]);

            foreach ($response['TicketItemInfo'] as $data) {

                $ticket = new FlightTicket();
                $ticket
                    ->setFirstName($data['GivenName'])
                    ->setLastName($data['Surname'])
                    ->setPrice($data['Amount'])
                    ->setCommision($data['Commission'])
                    ->setNumber($data['Ticket'])
                    ->setFlightReservationGds($gdsReservation)
                    ->setDate(new \DateTime())
                ;

                $manager->persist($ticket);
            }

            $gdsReservation->setStatus(FlightReservation::STATE_ACCEPTED);
            $manager->flush();
        }

        $reservation->setStatus(FlightReservation::STATE_ACCEPTED);
        $manager->flush();

        return compact('reservation');
    }

    /**
     * Todas las reglas de validacion para los parametros que recibe
     * el Handler
     *
     * Las reglas de validacion estan definidas en:
     * @see \App\Navicu\Service\NavicuValidator
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'publicId' => 'required'
        ];
    }
}