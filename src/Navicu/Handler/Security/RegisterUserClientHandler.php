<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Entity\ClienteProfile;
use App\Navicu\Handler\BaseHandler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Navicu\Exception\NavicuException;
/**
 * Verifica si existe un usuario
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class RegisterUserClientHandler extends BaseHandler
{
    /**
     * @return array
     */
    protected function handler() : array
    {

        $params = $this->getParams();        
        $manager = $this->container->get('doctrine')->getManager();
        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['email'], 'username' => $params['username'] ]);

        if (! empty($user)) {
            throw new NavicuException('User Exist', 400, ['email' => $params['email'], 'username' => $params['username']]);
        }
       
        $encoder = $params['encoder'];
        $generator = $params['generator'];
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

        $clientProfile = new ClienteProfile();
        $clientProfile->setFullName($name);
        $clientProfile->setIdentityCard($id);
        $clientProfile->setEmail($email);
        $clientProfile->setEmailNews(true);
        
        $clientProfile->setUser($user);
        $manager->persist($user);
        $manager->persist($clientProfile);
        $manager->flush();

        $token = $generator->create($user);

        $dataUser = [
            'email'=>$user->getEmail($email),
            'username'=>$user->getUsername($username),
            'plainPassword'=>$user->getPlainPassword($password),
            'token'=> $token
        ];

        return $dataUser;
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