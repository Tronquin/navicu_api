<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Flight\AutocompleteHandler;
use App\Navicu\Handler\Flight\BookFlightHandler;
use App\Navicu\Handler\Flight\CompleteReservationHandler;
use App\Navicu\Handler\Flight\ListBankHandler;
use App\Navicu\Handler\Flight\CabinHandler;
use App\Navicu\Handler\Flight\ListHandler;
use App\Navicu\Handler\Flight\ListClientReservationHandler;
use App\Navicu\Handler\Flight\ProcessFlightReservationHandler;
use App\Navicu\Handler\Flight\ResumeReservationHandler;
use App\Navicu\Handler\Flight\CreateReservationHandler;
use App\Navicu\Handler\Flight\SetTransferHandler;
use App\Navicu\Handler\Flight\TransferPaymentHandler;
use App\Navicu\Handler\Flight\ChangeFlightReservationStatusHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function autoComplete(Request $request)
    {
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
     * @Route("/list", name="flight_list", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function flightList(Request $request)
    {
        $handler = new ListHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Crea una reserva
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
     * Genera el book para una reserva. Actualmente esto
     * se utiliza para pagos por paypal
     *
     * 1. Genera book <---- (hace esto)
     * 2. Paypal cobra
     * 3. Emite ticket
     *
     * @Route("/book_reservation", name="flight_book_reservation", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bookReservation(Request $request)
    {
        $handler = new BookFlightHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Registra pago y emite ticket a una reserva. Actualmente
     * se utiliza para pagos por paypal
     *
     * 1. Genera book
     * 2. Paypal cobra
     * 3. Emite ticket <---- (hace esto)
     *
     * @Route("/complete_reservation", name="flight_complete_reservation", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function completeReservation(Request $request)
    {
        $handler = new CompleteReservationHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Genera el book, procesa el pago, genera el ticket
     * y envia correo de confirmacion de la reserva. Se
     * utiliza actualmente para pagos por TDC
     *
     * 1. Genera book   <---- (hace esto)
     * 2. Cobro TDC     <---- (hace esto)
     * 3. Emite ticket  <---- (hace esto)
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
     * Indica que opcion transferencia para una reserva
     *
     * @Route("/transfer_reservation", name="transfer_reservation", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setTransfer(Request $request)
    {
        $handler = new SetTransferHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Registra pagos a una transferencia
     *
     * @Route("/transfer_payment_reservation", name="transfer_payment_reservation", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function transferPayment(Request $request)
    {
        $handler = new TransferPaymentHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Obtiene listado de cuentas bancarias
     *
     * @Route("/list_bank/{currency}", name="list_bank_reservation", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listBank(Request $request)
    {
        $handler = new ListBankHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }


    /**
     * Cambia el estatus de la reservación por transferencia
     *
     * @Route("/change_flight_reservation_status", name="change_flight_reservation_status", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeFlightReservationStatus(Request $request)
    {
        $handler = new ChangeFlightReservationStatusHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Listar reservas por cliente y estatus
     *
     * @Route("/list_client_reservation/{email}/{status}", name="list_client_reservation", methods="GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ListClientReservation(Request $request)
    {
        $handler = new ListClientReservationHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
