<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\BankType;
use App\Entity\HolidayCalendar;
use App\Entity\NvcBank;
use App\Entity\FlightReservation;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Exception\NavicuException;
/**
 * Obtiene el listado de cabinas disponibles
 *
 * @author Javier Vasquez <jvasquez@gmail.com>
 */
class ConfirmPrereservationHandler extends BaseHandler
{
    /**
     *
     * Handler que retorna un listado de bancos deacuerdo a la moneda de la reserva 
     * @return array
     *
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();
        $reservation = $manager->getRepository(FlightReservation::class)->findOneByPublicId($params['publicId']);          
        $listReservationGds = $reservation->getGdsReservations();
        $currency = $listReservationGds[0]->getCurrencyReservation();
        $date = new \DateTime('now'); 


        if ($reservation->getExpireDate()->format('Y-m-d H:i:s') >= $date->format('Y-m-d H:i:s')) {           
            throw new NavicuException('Expired Reservation: ',BaseHandler::EXPIRED_RESERVATION);       
        }


        //$banks = $manager->getRepository(BankType::class)->getListBanksArray(1, true);
        $nvcBankList = $manager->getRepository(NvcBank::class)->findByCurrency($currency);          

        foreach ($nvcBankList as $nvcBank) {
            if ($nvcBank->getId() !== 2) {
                $receptors[] = [
                    'name' => $nvcBank->getName(),
                    'account_number' => $nvcBank->getAccountNumber(),
                    'billing_name' => $nvcBank->getBillingName(),
                    'billing_email' => $nvcBank->getBillingEmail(),
                    'cable_code' => $nvcBank->getCableCode(),
                    'swift_code' => $nvcBank->getSwiftCode(),
                    'routing_number' => $nvcBank->getRoutingNumber(),
                    'rif_code' => $nvcBank->getRifCode(),
                    'billing_address' => $nvcBank->getBillingAddress()
                ];
                $emisors[] = [
                    'name' => $nvcBank->getName(),
                ];
            }
        }      

        $response = [];
        $response['receptors'] = $receptors;
        $response['emisors'] = $emisors;
        $response['date_servidor'] = $date->format('Y-m-d H:i:s');
        $response['expire_date'] = $reservation->getExpireDate()->format('Y-m-d H:i:s');

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
            'publicId'=>'required'
        ];
    }
}