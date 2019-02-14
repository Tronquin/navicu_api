<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Navicu\Handler\ClientProfile\GetTypeReservationsHandler;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


/**
 * @Route("/client_profile")
 */
class ClientProfileController extends AbstractController
{
    /**
     * @Route("/type_reservations", name="type_reservations")
     */
    public function getTypeReservations(Request $request,  TokenStorageInterface $ti)
    {
        $handler = new GetTypeReservationsHandler($request);
        $handler->setParam('ti', $ti);
        $handler->processHandler();
        return $handler->getJsonResponseData();
    }

}
