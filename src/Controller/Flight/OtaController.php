<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Ota\FareFamilyHandler;
use App\Navicu\Handler\Ota\SeatMapHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ota")
 */
class OtaController extends AbstractController
{
    /**
     * Obtiene informacion de Fare Family
     *
     * @Route("/fare_family", name="flight_ota_fare_family", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fareFamily(Request $request)
    {
        $handler = new FareFamilyHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Obtiene el mapa de asientos del avion
     *
     * @Route("/seat_map", name="flight_ota_seat_map", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function seatMap(Request $request)
    {
        $handler = new SeatMapHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
