<?php

namespace App\Controller;

use App\Navicu\Handler\TestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
   
}
