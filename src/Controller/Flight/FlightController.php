<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Flight\AutocompleteHandler;
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
     * @Route("/autocomplete/{words}", name="flight_autocomplete")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $handler = new AutocompleteHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
