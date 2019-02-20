<?php

namespace App\Controller;

use App\Navicu\Handler\Security\UserExistsHandler;
use App\Navicu\Handler\Security\LoginUserHandler;
use App\Navicu\Handler\Security\DirectRegisterUserClientHandler;
use App\Navicu\Handler\SocialServices\SocialServiceHandler;
use App\Navicu\Handler\Security\LoginRedSocialClientHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/security")
 */
class SecurityController extends AbstractController
{
    /**
     * Valida que usuario existe
     *
     * @Route("/user_exists/{email}", name="user_exists")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function userExists(Request $request)
    {
        $handler = new UserExistsHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function getLoginCheckAction()
    {
    }

    /**
     * Autenticacion de usuario
     *
     * @Route("/login", name="login")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLoginAction(Request $request)
    {
        $handler = new LoginUserHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Registro de usuario
     *
     * @Route("/register", name="register")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registerClientAction(Request $request)
    {
        $handler = new DirectRegisterUserClientHandler($request);
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

    /**
     * Login red social
     *
     * @Route("/register_red_social", name="registerRedSocial")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginRedSocialClientAction(Request $request)
    {
        $handler = new LoginRedSocialClientHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

}
