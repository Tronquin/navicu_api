<?php

namespace App\Navicu\Handler\Main;

use App\Entity\CurrencyType;
use App\Entity\HolidayCalendar;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Resumen de Reservacion de vuelos
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */

class HolidayCalendarHandler extends BaseHandler
{
	/**
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
    	
    	$manager = $this->getDoctrine()->getManager();
        $holidayCalendar = $manager->getRepository(HolidayCalendar::class)->findAll();
        $params = $this->getParams();
        $date_now = $params['date'];
        $holiday_now = false;
        $holiday_yesterday = false;

        foreach ($holidayCalendar as $holiday)
        {
            $Holiday = $holiday->getFecha();
            $yesterday = strtotime ( '-1 day' , strtotime ( $Holiday->format('Y-m-d') ) ) ;
            $yesterday = date('Y-m-d' , $yesterday );
            
            if ($yesterday == $date_now->format('Y-m-d')) {
                $holiday_yesterday = true;
            }

            if ($Holiday->format('Y-m-d') == $date_now->format('Y-m-d')){
                $holiday_now = true;
            }          
        }     

        return [
                'holiday_now' => $holiday_now,
                'holiday_yesterday'=>$holiday_yesterday
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