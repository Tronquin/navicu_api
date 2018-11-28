<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\BankType;
use App\Entity\HolidayCalendar;
use App\Entity\NvcBank;
use App\Entity\FlightReservation;
use App\Navicu\Handler\BaseHandler;

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
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();
        $reservation = $manager->getRepository(FlightReservation::class)->findOneByPublicId($params['publicId']);

        $listReservationGds = $reservation->getGdsReservations();
        $currency = $listReservationGds[0]->getCurrencyReservation();

        $banks = $manager->getRepository(BankType::class)->getListBanksArray(1, true);
        $nvcBankList = $manager->getRepository(NvcBank::class)->findByCurrency($currency);

        /** @var \Navicu\Core\Domain\Model\Entity\NvcBank $nvcBank */
        foreach ($nvcBankList as $nvcBank) {
            $nvcBankArray[] = [
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
        } 

        $provider = 'KIU';
        foreach ($listReservationGds as $key => $regds) {   
            if ($regds->getGds()->getName() == 'AMA') {
                $provider = 'AMA';
                break;
            }            
        }                
        
        $holiday_now = false;
        $holiday_yesterday = false;
        $date_now = new \DateTime($reservation->getExpireDate()->format('Y-m-d H:i:s'));
        $date = new \DateTime('now');       
        
        /** descripcion **/
        $holidays = $this->HolidayCalendar($date_now); 

        $date_provider['date_provider'] = $date_now; 
        $expired['expired'] = $reservation->getExpireDate()->format('Y-m-d H:i:s');

        if (isset($provider)) {
            if ($provider == 'KIU') {
                if ($holidays['holiday_yesterday']) {
                   // $date_provider['date_provider'] = $date_now->format('21:00:00');
                    if ($date_now->format('H:i:s') >  $date->format('21:00:00')){
                        $date_provider['date_provider'] = $date_now->format('21:00:00');
                        $expired['expired']= $reservation->getExpireDate()->format('Y-m-d 21:00:00');
                    } else {
                        $date_provider['date_provider'] = $date_now->format('H:i:s');
                        $expired['expired']= $reservation->getExpireDate()->format('Y-m-d H:i:s');
                    }
                } else {
                   if( $date_now->format('H:i:s') >  $date->format('21:00:00')){
                       $date_provider['date_provider'] = $date_now->format('21:00:00');
                       $expired['expired']= $reservation->getExpireDate()->format('Y-m-d 21:00:00');
                   } else {
                       $date_provider['date_provider'] = $date_now->format('H:i:s');
                       $expired['expired']= $reservation->getExpireDate()->format('Y-m-d H:i:s');
                   }

                }
            } else {
                $date_provider['date_provider'] = $date_now->format('21:00:00');
            }
        }

        $full_year['full_year'] = $date_now->format('d-m-Y');
        $date_servidor['date_now'] = $date->format('H:i:s');
        $date_right['now'] = $date_now->format('H:i:s');
 
        $hour = $this->HourAction($provider);
       
        if(! $hour) {
            throw new NavicuException('Reserva caducada ');
        }

        $response = [];
        $response['receptors'] = $nvcBankList;
        $response['emisors'] = $banks;
        $response['date_provider'] = $date_provider;
        $response['full_year'] = $full_year;
        $response['date_servidor'] = $date_servidor;
        $response['expired'] = $expired;

        return $response;

    }


    public function HolidayCalendar($date_now) {

        $manager = $this->container->get('doctrine')->getManager();
        $holidayCalendar = $manager->getRepository(HolidayCalendar::class)->findAll();

        $holiday_now = false;
        $holiday_yesterday = false;

        foreach ($holidayCalendar as $holiday)
        {
            $Holiday = $holiday->getFecha();
            $yesterday = strtotime ( '-1 day' , strtotime ( $Holiday->format('Y-m-d') ) ) ;
            $yesterday = date('Y-m-d' , $yesterday );
            
            if( $yesterday == $date_now['date_now']->format('Y-m-d')) {
                $holiday_yesterday = true;
            }

            if($Holiday->format('Y-m-d') == $date_now['date_now']->format('Y-m-d')){
                $holiday_now = true;
            }          
        }

        return [
                'holiday_now' => $holiday_now,
                'holiday_yesterday'=>$holiday_yesterday
            ];

    }     

       


    public function HourAction($provider)
    {
        $date_now=new \DateTime('now');
       
        $holidays = $this->HolidayCalendar($date_now); 

        if ($provider == 'KIU') {
            if (date("w") == 5) {
                //$hour=date('H') < "21"? true :false;
                $hour=true;
            } else {
               if ($holidays['holiday_yesterday']) {
                     $hour=true;
               } else {
                   $hour=true;
               }
            }
        } else {
            if(($date_now->format('H:i:s') > "02:00:00")&& ($date_now->format('H:i:s') < "21:00:00")) {
                $hour=true;
            } else {
                $hour=false;
            }
        }
        return  $hour;
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