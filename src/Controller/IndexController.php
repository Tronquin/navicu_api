<?php

namespace App\Controller;

use App\Navicu\Handler\TestHandler;
use App\Navicu\Handler\Main\ListCurrencyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\FosUser;
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


}
