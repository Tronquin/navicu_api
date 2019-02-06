<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Entity\NvcProfile;
use App\Navicu\Handler\BaseHandler;

/**
 * Verifica si existe un usuario
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class RegisterUserSimpleHandler extends BaseHandler
{
    /**
     * @return array
     */
    protected function handler() : array
    {
        $params = $this->getParams();        
        $manager = $this->container->get('doctrine')->getManager();
        $user = $manager->getRepository(FosUser::class)->findOneBy([ 'email' => $params['email'] ]);
        $message = "";
        $encoder = $params['encoder'];
        $code = 200;
        $error = false;

        $name = $params['name'];
        $id = $params['id'];
        $email = $params['email'];
        $username = $params['username'];
        $password = $params['password'];

        $user = new FosUser();
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
        $manager->persist($user);
        $manager->flush();

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

        return [
            'exists' => !!$user
        ];
    }   


     /**
     * Todas las reglas de validacion para los parametros que recibe
     * el Handler
     *
     * Las reglas de validacion estan definidas en:
     * @see \App\Navicu\Service\NavicuValidator
     *
     * @return array
     */
    protected function validationRules() : array
    {
        return [
            'email' => 'required',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required'
        ];
    }
}        