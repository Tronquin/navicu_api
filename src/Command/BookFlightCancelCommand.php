<?php

namespace App\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use App\Navicu\Handler\Flight\CancelBookFlightHandler;
use App\Navicu\Handler\Flight\SendFlightDeniedEmailHandler;
use App\Entity\FlightReservation;
use Psr\Log\LoggerInterface;


/**
 * Actualiza la tasa de cambio de las monedas consultando apis de dolar today
 *
 * @author Vito Cervelli <cervelliv@gmail.com>
 */
class BookFlightCancelCommand extends Command
{
    use ContainerAwareTrait;

    protected static $defaultName = 'navicu:book:cancel';

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Cancela las las reservaciones de boleterias que no han pagado');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->container->get('monolog.logger.flight');
        $logger->warning('**********************************');
        $logger->warning('Cancelación de reservas no pagadas');

        $manager = $this->container->get('doctrine')->getManager();
        $flightReservation = [];
        $flightReservationRp = $manager->getRepository(FlightReservation::class);
        $flightReservations = $flightReservationRp->getExpiredFlight();

        foreach ($flightReservations as $flightReservation ) {
            //Cancela el vuelo en ota
            $handler = new CancelBookFlightHandler();
            $handler->setParam('publicId',  $flightReservation->getPublicId() );
            $handler->processHandler();
            if ($handler->isSuccess()) {
                $handler = new SendFlightDeniedEmailHandler();
                $handler->setParam('publicId',  $flightReservation->getPublicId() );
                $handler->processHandler();
                $logger->warning('La reserva con public_id '.$flightReservation->getPublicId(). 'fue cancelada correctamente');
                if (! $handler->isSuccess()) {
                    $logger->warning('Error al enviar correo de cancelación'.$flightReservation->getPublicId());
                }
            }else{
                $logger->warning('Ocurrió un error a cancelar la reserva con public id '.$flightReservation->getPublicId());
                $logger->warning(json_encode($handler->getErrors()));
            }
           
        }      
        $logger->warning('Fin Cancelación de reservas no pagadas ');
        $logger->warning('**********************************');
                
    }
}
