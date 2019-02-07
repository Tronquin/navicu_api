<?php

namespace App\Controller;

use App\Navicu\Handler\TestHandler;
use App\Navicu\Handler\Main\ListCurrencyHandler;
use App\Navicu\Handler\SocialServices\SocialServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/navicu")
 */ 
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $handler = new TestHandler();
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
   
   /**
     * @Route("/list_currency", name="listcurrency")
     */ 
   public function listCurrency()
   {
      $handler = new ListCurrencyHandler();
      $handler->processHandler();

        return $handler->getJsonResponseData();
   }

   /**
     * Obtiene el token secreto de las redes sociales (google, facebook,etc)
     *
     * @Route("/social_provider_data", name="socialproviderdata", methods="POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function socialProviderData(Request $request)
    {
        $handler = new SocialServiceHandler($request);
        $handler->processHandler();
        
        return $handler->getJsonResponseData();
    }


}
