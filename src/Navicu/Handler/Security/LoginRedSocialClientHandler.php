<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Entity\RedSocial;
use App\Navicu\Service\RedSocialService;
use App\Entity\ClientProfile;
use App\ClassEfect\ValueObject\Email;
use App\ClassEfect\ValueObject\Phone;
use App\Navicu\Handler\BaseHandler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Navicu\Exception\NavicuException;
/**
 * Verifica si existe un usuario
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class LoginRedSocialClientHandler extends BaseHandler
{
    /**
     * @return array
     */
    protected function handler() : array
    {

        $params = $this->getParams(); 
        $encoder = $params['encoder'];
        $generator = $params['generator'];  

        $manager = $this->container->get('doctrine')->getManager();
        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['email'], 'username' => null ]);

        $token = null;

        if (is_null($user)) {  



            if ($params['type'] === RedSocialService::FACEBOOK) {
                RedSocialService::validTokenFacebook(['input_token' => $params['token']]);
            }


            $client = new ClientProfile();        

            if (isset($params["name"])) {
                $client->setFullName($params["name"]);
            } 
            //$client->setIdentityCard($params["identityCard"]);
            $email = new Email($params['email']);
            $client->setEmail($email->toString());
            $client->setEmailNews(true);  
         
            $redSocial = new RedSocial();
            $redSocial->updateObject($params, $client);   
            
            $username = \explode('@',$params['email']);
            $username = $username[0];

            $i = 2;
            do {
                $auxUser =  $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => null, 'username' => $username]);
                if(! is_null($auxUser)) {
                    $username = $username . $i;
                    $i++;
                }
            } while(! is_null($auxUser));

            $params['username'] = $username;  
            $params['password'] = substr(sha1(uniqid(mt_rand(), true)),0,8);

            $user = new FosUser();
            $user->setEmail($params['email']);
            $user->setUsernameCanonical($params['username']);
            $user->setEmailCanonical($params['email']);
            $user->setUsername($params['username']);
            $user->setEnabled(true);
            $user->setLocked(true);
            $user->setSalt(123456);
            $user->setExpired(false);
            $user->setCredentialsExpired(false);
            $user->setPlainPassword($params['password']);
            $user->setPassword($encoder->encodePassword($user, $params['password']));
            $user->setCreatedAt(new \DateTime('now'));
            $user->setUpdatedAt(new \DateTime('now'));    
                  
            $client->setUser($user);

            $manager->persist($user);
            $manager->persist($client);
            $manager->persist($redSocial);
            
            $manager->flush();

        } else {



        }


        /*
            $dataEmail['user'] = $client->getUser();
            $dataEmail['email'] = $client->getEmail()->toString();
            $dataEmail['password'] = $user->getPlainPassword();
            $dataEmail['fullName'] = $client->getFullName();
            $dataEmail['generatedPassword'] = isset($params["pass1"],$params["pass2"]) ? false : true;
        */

        $token = $generator->create($user);        
       
        return ['token' => $token];
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
            'url' => 'required',
            'type' => 'required',
            'token' => 'required',
            'idSocial' => 'required'
        ];
    }
}        