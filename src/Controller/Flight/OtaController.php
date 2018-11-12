<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Ota\FareFamilyHandler;
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
}
