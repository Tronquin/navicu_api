<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;
use App\Entity\FlightPayment;
use App\Entity\BankType;

/**
 * Envia el correo de pago de pre confirmacion de la reserva de boleteria
 * con informacion del ticket a navicu
 *
 * @author Deivis Millan <deivisjose.d@gmail.com>
 */
class SendFlightPaymentPreReservationEmailHandler extends BaseHandler
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
       
        $recipients = []; 
        foreach ($reservation->getGdsReservations() as $gdsReservation) {
            foreach ($gdsReservation->getFlightReservationPassengers() as $flightReservationPassenger) {
                $recipients[] = $flightReservationPassenger->getPassenger()->getEmail();
            }
            break;

        }
        
         $reservationId=$reservation->getId();
         $flightReservation = $manager->getRepository(FlightPayment::class)->findOneBy(['flightReservation' => $reservation]);
         
         $referenceBank=$flightReservation->getReference();

         $bankId=$flightReservation->getBank();
         $backIdReceiver=$flightReservation->getReceiverBank();
         $bank = $manager->getRepository(BankType::class)->findOneBy(['id' => $bankId]);
         $bankName=$bank->getTitle();
         $bank = $manager->getRepository(BankType::class)->findOneBy(['id' => $backIdReceiver]);
         $bankNamePaymentReceiver=$bank->getTitle();

         if($bankId=="E000"){
           $varJson=str_replace('{Banco Emisor:','',$flightReservation->getResponse());
           $varJson=str_replace('}','',$varJson);
           $bankName=$varJson;
         }
        
        $handler = new ResumeReservationHandler();
        $handler->setParam('public_id', $params['publicId']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            throw new NavicuException('Email data not found');
        }

        $data = $handler->getData()['data'];
        $data['referenceBankPayment'] = $referenceBank;
        $data['bankNamePayment'] = $bankName;
        $data['bankNamePaymentReceiver'] = $bankNamePaymentReceiver;

        //Obtengo la moneda de la reservación
        $currencyReservation =$reservation->getGdsReservations()[0]->getCurrencyReservation();
        //Obtengo la lista de bancos
        $handler = new ListBankHandler();
        $handler->setParam('currency', $currencyReservation->getAlfa3());
        $handler->processHandler();
        $data['nvcBanks'] = $handler->getData()['data']['receptors'];

        // Envia correo a los pasajeros
        /*$data['amountsInLocalCurrency'] = false;
        $data['sendNavicu'] = false;
        EmailService::send(
            $recipients,
            'Pre-Reserva de boletos - navicu',
            'Email/Flight/flightPreReservationConfirmation.html.twig',
            $data
        );*/

        // Envia correo a navicu
        $data['amountsInLocalCurrency'] = true;
        $data['sendNavicu'] = true;
        EmailService::sendFromEmailRecipients(
            'flightResume',
            'Pago de pre-reserva de boleto - navicu',
            'Email/Flight/flightPaymentPreReservationConfirmation.html.twig',
            $data
        );

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