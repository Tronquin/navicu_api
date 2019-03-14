<?php

namespace App\Controller;

use App\Navicu\Handler\Main\GetNotificationHandler;
use App\Navicu\Handler\TestHandler;
use App\Navicu\Handler\Main\ListCurrencyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/navicu")
 */ 
class IndexController extends AbstractController
{
    /**
     * Prueba a la api debe retornar "navicu is ok"
     *
     * @Route("/", name="index_api")
     *
     * @return JsonResponse
     */
    public function index()
    {
        $handler = new TestHandler();
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Obtiene listado de monedas
     *
     * @Route("/list_currency", name="listcurrency", methods={"GET"})
     *
     * @return JsonResponse
     */
   public function listCurrency()
   {
      $handler = new ListCurrencyHandler();
      $handler->processHandler();

        return $handler->getJsonResponseData();
   }

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
