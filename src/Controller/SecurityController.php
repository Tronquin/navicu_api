<?php

namespace App\Controller;

use App\Navicu\Handler\Security\UserExistsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/security")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/user_exists/{email}", name="register")
     */
    public function userExists(Request $request)
    {
        $handler = new UserExistsHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
