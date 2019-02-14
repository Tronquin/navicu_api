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
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $token_interface = $params['ti'];
        $manager = $this->container->get('doctrine')->getManager();

        $flightReservations = $reservations = [];
        if (is_object($token_interface->getToken()->getUser())) {

            if (null !== $token_interface->getToken()->getUser()->getClientProfile() && $token_interface->getToken()->getUser()->getClientProfile()[0]) {
                $flightReservations = $manager->getRepository(FlightReservation::class)->findBy(['clientProfile' => $token_interface->getToken()->getUser()->getClientProfile()[0]]);
                $reservations = $manager->getRepository(Reservation::class)->findBy(['client' => $token_interface->getToken()->getUser()->getClientProfile()[0]]);
            }

        } else {
            throw new NavicuException('invalid token' );
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
        return [
        ];
    }
}