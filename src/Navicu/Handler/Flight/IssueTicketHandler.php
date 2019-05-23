<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\FlightReservation;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\AirlineService;
use App\Navicu\Service\ConsolidatorService;
use App\Navicu\Service\NotificationService;
use App\Navicu\Service\OtaService;
use Symfony\Component\Dotenv\Dotenv;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
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
            } else {
                 $response = OtaService::ticketTest([
                    'country' => $country,
                    'currency' => $currency,
                    'PaymentType' => 1, // Cash Kiu
                    'BookingID' => $gdsReservation->getBookCode(),
                    'provider' => $gdsReservation->getGds()->getName()
                ]);
            }
            $logger = $this->container->get('monolog.logger.flight');
            $logger->warning('**********************************');
            $logger->warning('Recibiendo respuesta OTA');
            $logger->warning(json_encode($response));
            foreach ($response['TicketItemInfo'] as $data) {

                foreach ($gdsReservation->getFlightReservationPassengers() as $flightReservationPassenger) {
                    // A cada pasajero le asigno su numero de ticket

                    $name = $flightReservationPassenger->getPassenger()->getName();
                    $lastName = $flightReservationPassenger->getPassenger()->getLastname();
                    $logger->warning('**********************************');
                    $logger->warning($name);
                    $logger->warning('**********************************');
                    $logger->warning('**********************************');
                    $logger->warning($lastName);
                    $logger->warning('**********************************');
                    $logger->warning(!$flightReservationPassenger->hasTicket());
                    $logger->warning(strtolower($name) === strtolower($data['GivenName']));
                    $logger->warning( strtolower($lastName) === strtolower($data['Surname']));
                    $logger->warning('**********************************');
                    if (
                        strtolower($name) === strtolower($data['GivenName']) &&
                        strtolower($lastName) === strtolower($data['Surname']) &&
                        ! $flightReservationPassenger->hasTicket()
                    ) {
                        $logger->warning('**********************************');
                        $logger->warning('Guardando ticket en Base de datos');
                        $logger->warning(json_encode($data));
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