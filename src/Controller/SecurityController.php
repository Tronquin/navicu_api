<?php

namespace App\Controller;

use App\Navicu\Handler\Security\UserExistsHandler;
use App\Navicu\Handler\Security\LoginUserHandler;
use App\Navicu\Handler\Security\RegisterUserClientHandler;
use App\Navicu\Handler\Security\DirectRegisterUserClientHandler;
use App\Navicu\Handler\SocialServices\SocialServiceHandler;
use App\Navicu\Handler\Security\LoginRedSocialClientHandler;
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
     * @Route("/login_check", name="login_check")
     */
    public function getLoginCheckAction()
    { 
        // $password = substr(sha1(uniqid(mt_rand(), true)),0,8);
    }

    /**
     * @Route("/login", name="login")
     */
    public function getLoginAction(Request $request, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $JWTManager)
    { 
        $handler = new LoginUserHandler($request);
        $handler->setParam('encoder', $encoder);
        $handler->setParam('generator', $JWTManager);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerClientAction(Request $request, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $JWTManager)
    {
        $handler = new DirectRegisterUserClientHandler($request);
        $handler->setParam('encoder', $encoder);
        $handler->setParam('generator', $JWTManager);
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
     * @Route("/register_red_social", name="registerRedSocial")
     */
    public function loginRedSociaClientlAction(Request $request, UserPasswordEncoderInterface $encoder, JWTTokenManagerInterface $JWTManager)
    {
        $handler = new LoginRedSocialClientHandler($request);
        $handler->setParam('encoder', $encoder);
        $handler->setParam('generator', $JWTManager);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

}
