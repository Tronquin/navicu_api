<?php

namespace App\Controller;

use App\Navicu\Handler\Security\UserExistsHandler;
use App\Navicu\Handler\Security\RegisterUserSimpleHandler;
use App\Navicu\Handler\SocialServices\SocialServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $handler = new RegisterUserSimpleHandler($request);
        $handler->setParam('encoder', $encoder);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Devuelve el token secreto de las redes sociales (google, facebook,etc)
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
