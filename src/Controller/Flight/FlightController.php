<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Flight\AutocompleteHandler;
use App\Navicu\Handler\Flight\CabinHandler;
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
}
