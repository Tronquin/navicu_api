<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\AirlineService;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\EmailService;
use App\Navicu\Service\NotificationService;
use App\Navicu\Service\OtaService;
use Symfony\Component\Dotenv\Dotenv;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use App\Navicu\Service\LogGenerator;
/**
 * Genera el ticket para una reserva
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class IssueTicketHandler extends BaseHandler
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
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../../.env');

        /** @var FlightReservation $reservation */
        $reservation = $manager->getRepository(FlightReservation::class)->findOneBy(['publicId' => $params['publicId']]);

        if (! $reservation) {
            throw new NavicuException(sprintf('Reservation "%s" not found', $params['publicId']));
        }

        foreach ($reservation->getGdsReservations() as $gdsReservation) {

            $currency = $gdsReservation->getCurrencyGds()->getAlfa3();
            $country = $currency === 'USD' ? 'US' : 'VE';

            if (getenv('APP_ENV') === 'prod') {
                 $response = OtaService::ticket([
                    'country' => $country,
                    'currency' => $currency,
                    'PaymentType' => 1, // Cash Kiu
                    'BookingID' => $gdsReservation->getBookCode(),
                    'provider' => $gdsReservation->getGds()->getName()
                 ]);

                if ($response['code'] === BaseHandler::CODE_TICKET_ERROR) {
                    $this->sendEmailTicketFail($params['publicId']);
                    return [
                        'code' => $response['code'],
                        'publicId' => $params['publicId']
                    ];
                }

            } else {
                 $response = OtaService::ticketTest([
                    'country' => $country,
                    'currency' => $currency,
                    'PaymentType' => 1, // Cash Kiu
                    'BookingID' => $gdsReservation->getBookCode(),
                    'provider' => $gdsReservation->getGds()->getName()
                ]);

                if ($response['code'] === BaseHandler::CODE_TICKET_ERROR) {
                    $this->sendEmailTicketFail($params['publicId']);
                    return [
                        'code' => $response['code'],
                        'publicId' => $params['publicId']
                    ];
                }
            }
            LogGenerator::saveFlight('Respuesta ticket OTA IssueTicketHandler',json_encode($response));
            foreach ($response['TicketItemInfo'] as $data) {

                foreach ($gdsReservation->getFlightReservationPassengers() as $flightReservationPassenger) {
                    // A cada pasajero le asigno su numero de ticket
         
                
                   
                    $name = $flightReservationPassenger->getPassenger()->getName();
                    $lastName = $flightReservationPassenger->getPassenger()->getLastname();

                    //Limpia los acentos para comparar con la ota
                    $name = $this->cleantext($name);
                    $lastName = $this->cleantext($lastName);

                    LogGenerator::saveFlight('Comparación de Nombres y Apellido IssueTicketHandler',
                    json_encode(['nameNavicu'=>$name, 'nameOta' => $data['GivenName'],'lastNameNavicu'=>$lastName, 'lastNameOta' => $data['Surname'],'hasticketpassanger'=> $flightReservationPassenger->hasTicket()]));
                
                    if (
                        strtolower($name) === strtolower($data['GivenName']) &&
                        strtolower($lastName) === strtolower($data['Surname']) &&
                        ! $flightReservationPassenger->hasTicket()
                    ) {
                        LogGenerator::saveFlight('Guardando ticket en Base de datos IssueTicketHandler',json_encode($data));
                        $flightReservationPassenger
                            ->setPrice($data['Amount'])
                            ->setCommision($data['Commission'])
                            ->setTicket($data['Ticket'])
                            ->setDate(new \DateTime())
                        ;

                        $manager->flush();

                        break;
                    }
                }
            }

            $gdsReservation->setStatus(FlightReservation::STATE_ACCEPTED);
            $manager->flush();
        }

        $reservation->setStatus(FlightReservation::STATE_ACCEPTED);
        $manager->flush();

        // Movimientos en los creditos de aerolinea y consolidador
        ConsolidatorService::setMovementFromReservation($reservation);
        AirlineService::setMovementFromReservation($reservation, '-');

        return $response;
    }

    private function cleantext($name){
        $name = str_replace('á', 'a',   $name);
        $name = str_replace('Á', 'A',   $name);
        $name = str_replace('é', 'e',   $name);
        $name = str_replace('É', 'E',   $name);
        $name = str_replace('í', 'i',   $name);
        $name = str_replace('Í', 'I',   $name);
        $name = str_replace('ó', 'o',   $name);
        $name = str_replace('Ó', 'O',   $name);
        $name = str_replace('ú', 'u',   $name);
        $name = str_replace('Ú', 'U',   $name);

        return $name;

    }

    /**
     * Envia correo cuando hay un fallo al generar el ticket
     *
     * @param string $publicId
     */
    private function sendEmailTicketFail(string $publicId) {
        $handler = new SendFlightTicketFailEmailHandler();
        $handler->setParam('publicId', $publicId);
        $handler->processHandler();

        if (! $handler->isSuccess()) {

            // Si falla el correo se notifica a navicu para gestion offline
            $this->sendEmailAlternative( $publicId );
        }
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
    protected function validationRules(): array
    {
        return [
            'publicId' => 'required'
        ];
    }
}