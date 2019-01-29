<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Flight\AutocompleteHandler;
use App\Navicu\Handler\Flight\ConfirmPrereservationHandler;
use App\Navicu\Handler\Flight\CabinHandler;
use App\Navicu\Handler\Flight\ListHandler;
use App\Navicu\Handler\Flight\ProcessFlightReservationHandler;
use App\Navicu\Handler\Flight\ResumeReservationHandler;
use App\Navicu\Handler\Flight\CreateReservationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @Route("/flight")
 */
class FlightController extends AbstractController
{
    /**
     * Autocompletado para el buscador de boleteria
     *
     * @Route("/autocomplete/{words}", name="flight_autocomplete", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function autoComplete(Request $request, TokenStorageInterface $tt)
    {

        dump($tt->getToken()->getUser());
        die;

        $handler = new AutocompleteHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Obtiene listado de cabinas (First class, business, etc)
     *
     * @Route("/cabins", name="flight_cabins", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cabins(Request $request)
    {
        $handler = new CabinHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }


     /**
     * Obtiene listado de vuelos 
     *
     * @Route("/list", name="flight_list", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        $handler = new ListHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }



     /**
     * Obtiene calendario de vuelos
     *
     * @Route("/calendar", name="flight_calendar", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function calendar(Request $request)
    {
        $handler = new CalendarHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }


    /**
     * Obtiene calendario de vuelos
     *
     * @Route("/create_reservation", name="flight_reservation", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createReservation(Request $request)    {

        $handler = new CreateReservationHandler($request);       
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }



    /**
     * Obtiene listado de vuelos 
     *
     * @Route("/resume", name="flight_resume_resevation", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resumeReservation(Request $request)
    {
        $handler = new ResumeReservationHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Genera el book, procesa el pago, genera el ticket
     * y envia correo de confirmacion de la reserva
     *
     * @Route("/process_reservation", name="flight_process_reservation", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function processReservation(Request $request)
    {
        $handler = new ProcessFlightReservationHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }


    /**
     * Muestra la información necesara para la confirmación de la rerserva NO TDC
     *
     * @Route("/confirm_prereservation", name="flight_confirm_prereservation", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmPrereservation(Request $request)
    {
        $handler = new ConfirmPrereservationHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }


}
