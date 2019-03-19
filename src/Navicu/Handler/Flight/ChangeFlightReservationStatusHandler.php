<?php

namespace App\Navicu\Handler\Flight;


use App\Navicu\Handler\BaseHandler;
use App\Navicu\Exception\NavicuException;
use App\Entity\FlightReservation;
use App\Entity\FlightPayment;
use App\Entity\CurrencyType;
use App\Navicu\Service\NavicuFlightConverter;
use App\Navicu\Service\NavicuCurrencyConverter;
/**
 * Confirma o rechaza la reservas realizadas por transferencias
 *
 */
class ChangeFlightReservationStatusHandler extends BaseHandler
{
 
    /**
     * Handler que valida el monto de la transferencia y acepta o rechaza la reservación
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();
        $publicId = $params['publicId'];
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $publicId ]);
        $totalReservation = 0;
        $status = $params['status'];
        $amountTransferred =  $params['amountTransferred'];
    
        if ($reservation->getStatus() == FlightReservation::STATE_IN_PROCESS){
            //Procesa la reserva
            if($status == FlightReservation::STATE_ACCEPTED){
                    //Calculo el total de la reservación
                foreach ($reservation->getGdsReservations() as $reservationGds) {
                    $currencyRateConvertion = $reservationGds->getCurrencyRateConvertion();
                    $currencyRateConvertion = $currencyRateConvertion ?? 0.0;
                    $totalReservation += NavicuCurrencyConverter::convertToRate($reservationGds->getTotal(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                }
                 /*| **********************************************************************
                    *| Paso 1:
                    *| - Verifica si el pago del cliente es igual o mayor al monto de la reserva
                    * .......................................................................
                    */
                if( $this->paymentComplete($reservation->getId(),$amountTransferred, $totalReservation)){

                    /*| **********************************************************************
                    *| Paso 2:
                    *| - Genera el ticket en OTA
                    *| - Registra los ticket en DB y los asocia a la reserva
                    * .......................................................................
                    */
                    $handler = new IssueTicketHandler();
                    $handler->setParam('publicId',  $publicId );
                    $handler->processHandler();
                    if (! $handler->isSuccess()) {
                        $this->addErrorToHandler( $handler->getErrors()['errors'] );

                        throw new NavicuException('IssueTicketHandler fail', $handler->getErrors()['code'], $handler->getErrors()['params'] );
                    }

                    $responseData = $handler->getData()['data'];

                    /*| **********************************************************************
                    *| Paso 3:
                    *| - Envia correo de confirmacion a los pasajeros y a navicu
                    * .......................................................................
                    */
                    $handler = new SendFlightReservationEmailHandler();
                    $handler->setParam('publicId',  $publicId );
                    $handler->processHandler();

                    if (! $handler->isSuccess()) {
                        // Si falla el correo se notifica a navicu para gestion offline
                        $this->sendEmailAlternative( $publicId );
                    }

                    return $responseData;

                }else{

                    throw new NavicuException('Payment incomplete ChangeFlightReservationStatusHandler fail', BaseHandler::CODE_BAD_REQUEST );
                }
              
                
            }
              // cancela la reserva
            if($status == FlightReservation::STATE_CANCEL){

                foreach ($reservation->getGdsReservations() as $reservationGds) {
                    $reservationGds->setStatus(FlightReservation::STATE_CANCEL);
                    $manager->flush();
                }
                $reservation->setStatus(FlightReservation::STATE_CANCEL);
                $manager->flush();
                return [
                    "code"=> 200
                ];
            }
            // se debe cambiar el estatus a cancelada o aceptada
            if($status == FlightReservation::STATE_IN_PROCESS){
                throw new NavicuException('change status ChangeFlightReservationStatusHandler fail', BaseHandler::CODE_BAD_REQUEST );
            }
            
        }else{
            throw new NavicuException('estatus invalid ChangeFlightReservationStatusHandler fail', BaseHandler::CODE_BAD_REQUEST );
        }    
        
    }

     /**
     * Verifica si el monto esta completo y se actualiza la tabla de pago con el total transferido
     *
     * @return float
     */
    private function paymentComplete($reservationId,$TotalTransferred, $totalReservation) : bool
    {
        $paymentComplete = false;
        $manager = $this->container->get('doctrine')->getManager();

        $flightPayment = $manager->getRepository(FlightPayment::class)->findOneBy(['flightReservation' => $reservationId ]);
        if ($TotalTransferred >= $totalReservation ) {
            $paymentComplete= true;
            $flightPayment->setAmountTransferred($TotalTransferred);
            $flightPayment->setState(1);
            $manager->flush();
        }
    
        
    
        return $paymentComplete ;
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
            'publicId' => 'required',
            'status' =>'required | in: 1,2,3',
            'amountTransferred' => 'required'
        ];
    }
}