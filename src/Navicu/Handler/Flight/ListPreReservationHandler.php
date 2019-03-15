<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Entity\FosUser;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Lista las reservas pendientes de confirmacion
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ListPreReservationHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();
        /** @var FosUser $user */
        $user = $manager->getRepository(FosUser::class)->findOneBy(['email' => $params['email']]);

        if (! $user) {
            throw new NavicuException('User not found');
        }

        $response = [];
        $reservations = $manager->getRepository(FlightReservation::class)->findBy([
            'status' => FlightReservation::STATE_IN_PROCESS
        ]);

        /** @var FlightReservation $reservation */
        foreach ($reservations as $reservation) {

            $total = 0;
            $subTotal = 0;
            $tax = 0;
            $incrementGuarantee = 0;
            $incrementExpenses = 0;
            $discount = 0;
            $symbol = '';
            foreach ($reservation->getGdsReservations() as $gdsReservation) {
                $total += $gdsReservation->getTotal();
                $subTotal += $gdsReservation->getSubtotal();
                $tax += $gdsReservation->getTax();
                $incrementGuarantee += $gdsReservation->getIncrementGuarantee();
                $incrementExpenses += $gdsReservation->getIncrementExpenses();
                $discount += $gdsReservation->getDiscount();
                $symbol = $gdsReservation->getCurrencyReservation()->getSimbol();
            }

            $response[] = [
                'publicId' => $reservation->getPublicId(),
                'date' => $reservation->getReservationDate()->format('Y-m-d H:i:s'),
                'type' => $reservation->getType(),
                'currency' => $reservation->getGdsReservations()[0]->getCurrencyReservation()->getAlfa3(),
                'code' => '',
                'total' => $total,
                'subTotal' => $subTotal,
                'tax' => $tax,
                'incrementGuarantee' => $incrementGuarantee,
                'incrementExpenses' => $incrementExpenses,
                'discount' => $discount,
                'numberAdults' => $reservation->getAdultNumber(),
                'numberKids' => $reservation->getChildNumber(),
                'currencySymbol' => $symbol
            ];
        }

        return $response;
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
            'email' => 'required'
        ];
    }
}