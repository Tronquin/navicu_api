<?php

namespace App\Navicu\Handler\Flight;


use App\Navicu\Handler\BaseHandler;
use App\Navicu\Exception\NavicuException;
use App\Entity\FlightReservation;
use App\Entity\FlightPayment;
use App\Entity\CurrencyType;
use App\Navicu\Service\EmailService;
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
        $manager = $this->getDoctrine()->getManager();
        $params = $this->getParams();
        $publicId = $params['publicId'];
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $publicId ]);
        $totalReservation = 0;
        $status = $params['status'];
        $amountTransferred =  $params['amountTransferred'];

        $incrementExpenses = $incrementGuarantee = $discount = $subTotal = $markupIncrementAmount = $incrementConsolidator = $tax  = 0;
        $round = 2;

    
        if ($reservation->getStatus() == FlightReservation::STATE_IN_PROCESS){
            //Procesa la reserva
            if($status == FlightReservation::STATE_ACCEPTED){
                    //Calculo el total de la reservación
                foreach ($reservation->getGdsReservations() as $reservationGds) {
                    $currencyRateConvertion = $reservationGds->getCurrencyRateConvertion();
                    $currencyRateConvertion = $currencyRateConvertion ?? 0.0;
                    $subTotal += NavicuCurrencyConverter::convertToRate(
                        $reservationGds->getSubtotal(), 
                        CurrencyType::getLocalActiveCurrency()->getAlfa3(), 
                        $reservationGds->getCurrencyReservation()->getAlfa3(), 
                        $reservationGds->getDollarRateConvertion(),
                        $currencyRateConvertion);
                    $incrementExpenses += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementExpenses(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                    $incrementGuarantee += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementGuarantee(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                    $discount += NavicuCurrencyConverter::convertToRate($reservationGds->getDiscount(),CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                    $tax += NavicuCurrencyConverter::convertToRate($reservationGds->getTax(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                    $markupIncrementAmount += NavicuCurrencyConverter::convertToRate($reservationGds->getMarkupIncrementAmount(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                    $incrementConsolidator += NavicuCurrencyConverter::convertToRate($reservationGds->getIncrementConsolidator(), CurrencyType::getLocalActiveCurrency()->getAlfa3(), $reservationGds->getCurrencyReservation()->getAlfa3(), $reservationGds->getDollarRateConvertion(), $currencyRateConvertion);
                    $subTotal = round($subTotal,$round) ;
                    $tax = round($tax, $round);
                    $incrementExpenses = round($incrementExpenses, $round);
                    $incrementGuarantee = round($incrementGuarantee, $round);
                    $discount = round($discount, $round);
                    $totalReservation = round($subTotal + $tax + $incrementExpenses + $incrementGuarantee - $discount , $round);
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

                    if ($responseData['code'] !== BaseHandler::CODE_TICKET_ERROR) {
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

                    }

                    return $responseData;

                }else{

                    throw new NavicuException('Payment incomplete ChangeFlightReservationStatusHandler fail', BaseHandler::CODE_BAD_REQUEST );
                }
              
                
            }
              // cancela la reserva
            if($status == FlightReservation::STATE_CANCEL){
                //Cancela el vuelo en ota
                $handler = new CancelBookFlightHandler();
                $handler->setParam('publicId',  $publicId );
                $handler->processHandler();
                //Envia correo de reserva cancelada 
                if ($handler->isSuccess()) {
                    $handler = new SendFlightDeniedEmailHandler();
                    $handler->setParam('publicId',  $publicId );
                    $handler->setParam('PaymentDenied', false);
                    $handler->processHandler();
                    return [
                        "code"=> 200
                    ];
                }else{

                    throw new NavicuException('Error In Cancel Book OTA', BaseHandler::CODE_BAD_REQUEST );
                }
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
        $manager = $this->getDoctrine()->getManager();
        
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
     * Envia correo alternativo en caso que falle el envio del
     * correo de confirmacion con el numero del ticket al cliente.
     * La intencion es notificar a navicu sobre el fallo y gestionar
     * el envio del numero del ticket, el resto del proceso deberia
     * estar correcto.
     *
     * @param string $publicId
     */
    private function sendEmailAlternative(string $publicId) : void
    {
        EmailService::sendFromEmailRecipients(
            'flightResume',
            'Fallo correo confirmacion de ticket - navicu.com',
            'Email/Flight/emailTicketFail.html.twig',
            compact('publicId')
        );
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