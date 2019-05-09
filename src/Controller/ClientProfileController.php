<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Navicu\Handler\ClientProfile\GetTypeReservationsHandler;

/**
 * @Route("/client_profile")
 */
class ClientProfileController extends AbstractController
{
    /**
     * @Route("/type_reservations", name="type_reservations")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTypeReservations(Request $request)
    {
        $handler = new GetTypeReservationsHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

}
