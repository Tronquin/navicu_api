<?php

namespace App\Navicu\Handler\ClientProfile;

use App\Entity\FlightReservation;
use App\Entity\Reservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use Symfony\Component\HttpFoundation\Cookie;

/**
 *
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class GetTypeReservationsHandler extends BaseHandler
{
    /**
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $token_interface = $this->container->get('security.token_storage');
        $manager = $this->getDoctrine()->getManager();

        if (! is_object($token_interface->getToken()->getUser())) {
            throw new NavicuException('invalid token');
        }

        $flightReservations = [];
        $reservations = [];

        if (
            null !== $token_interface->getToken()->getUser()->getClientProfile() &&
            ($clientProfile = $token_interface->getToken()->getUser()->getClientProfile()[0])
        ) {
            $flightReservations = $manager->getRepository(FlightReservation::class)->findBy(compact('clientProfile'));
            $reservations = $manager->getRepository(Reservation::class)->findBy(['client' => $clientProfile]);
        }

        return [
            'reservations' => count($reservations),
            'flightReservations' => count($flightReservations)
        ];
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
    protected function validationRules() : array
    {
        return [];
    }
}