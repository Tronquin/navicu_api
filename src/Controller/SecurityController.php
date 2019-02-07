<?php

namespace App\Controller;

use App\Navicu\Handler\Security\UserExistsHandler;
use App\Navicu\Handler\Security\RegisterUserClientHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

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

    /**
     * @Route("/login_check", name="login")
     */
    public function getLoginCheckAction()
    { 

    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $JWTManager)
    {
        $handler = new RegisterUserClientHandler($request);
        $handler->setParam('encoder', $encoder);
        $handler->setParam('generator', $JWTManager);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }


}
