<?php

namespace App\Controller;

use App\Navicu\Handler\TestHandler;
use App\Navicu\Handler\Main\ListCurrencyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
//use FOS\RestBundle\Controller\FOSRestController;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\FosUser;
use App\Entity\NvcProfile;
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
     * @Route("/login_check", name="login")
     */
    public function getLoginCheckAction() 
    { }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        
        $serializer = $this->get('serializer');

        $em = $this->getDoctrine()->getManager();
 
        $user = [];
        $message = "";
 
        try {
            $code = 200;
            $error = false;

            $params = json_decode($request->getContent(), true);
          
            $name = $params['name'];
            $id = $params['id'];
            $email = $params['email'];
            $username = $params['username'];
            $password = $params['password'];
 
            $user = new FosUser();
            //$user->setName($name);
            $user->setEmail($email);
            $user->setUsernameCanonical($username);
            $user->setEmailCanonical($email);
            $user->setUsername($username);
            $user->setEnabled(true);
            $user->setLocked(true);
            $user->setSalt(123456);
            $user->setExpired(false);
            $user->setCredentialsExpired(false);
            $user->setPlainPassword($password);
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setCreatedAt(new \DateTime('now'));
            $user->setUpdatedAt(new \DateTime('now'));

            $nvcProfile = new NvcProfile();
            $nvcProfile->setFullName($name);
            $nvcProfile->setIdentityCard($id);

            $user->setNvcProfile($nvcProfile);
            $nvcProfile->setUser($user);   
 
            $em->persist($user);
            $em->flush();
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to register the user - Error: {$ex->getMessage()}";
        }

        $dataUser = [
            'email'=>$user->getEmail($email),
            'username'=>$user->getUsername($username),
            'plainPassword'=>$user->getPlainPassword($password),
            'password'=>$user->getPassword()
        ];
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $dataUser : $message,
        ];

        return new JsonResponse($response);
    }


}
