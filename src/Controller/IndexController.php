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
    throw new Exception("Value must be 1 or below");
      $handler = new ListCurrencyHandler();
      $handler->processHandler();

        return $handler->getJsonResponseData();
   }
}
