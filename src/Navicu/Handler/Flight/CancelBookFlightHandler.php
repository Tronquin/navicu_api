<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\FlightReservationPassenger;
use App\Entity\FlightReservation;
use App\Entity\FlightReservationGds;
use App\Entity\Passenger;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\NavicuCurrencyConverter;
use App\Navicu\Service\OtaService;

/**
 * Cancela booking para una reserva
 *
 * @author Vito Cervelli <cervelliv@gmail.com>
 */
class CancelBookFlightHandler extends BaseHandler
{    
    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler(): array
    {
        $manager = $this->getDoctrine()->getManager();
        $params = $this->getParams();

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        foreach ($reservation->getGdsReservations() as $reservationGds) {
            $currency = $reservationGds->getCurrencyGds()->getAlfa3();
            $country = $currency === 'USD' ? 'US' : 'VE';
            $response = OtaService::cancel([
                'country' => $country,
                'currency' => $currency,
                'pnr' => $reservationGds->getBookCode(),
                'provider' => $reservationGds->getGds()->getName()
            ]);

            $reservationGds->setStatus(FlightReservation::STATE_CANCEL);
            $manager->flush();
        }
        $reservation->setStatus(FlightReservation::STATE_CANCEL);
        $manager->flush();
        return compact('response');
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
            'publicId' => 'required',
        ];
    }


}