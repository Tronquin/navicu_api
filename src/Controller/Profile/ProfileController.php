<?php

namespace App\Controller\Profile;

use App\Navicu\Handler\Main\GetNotificationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{

    /**
     * Obtiene el listado de notificaciones sin leer
     * para un usuario
     *
     * @Route("/notifications", name="notifications", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function notifications()
    {
        $handler = new GetNotificationHandler();
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
