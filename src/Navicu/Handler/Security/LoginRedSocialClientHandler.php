<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Entity\RedSocial;
use App\Navicu\Service\RedSocialService;
use App\Entity\ClientProfile;
use App\ClassEfect\ValueObject\Email;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Exception\NavicuException;
use Symfony\Component\Dotenv\Dotenv;
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
        
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../../.env');

        $manager = $this->container->get('doctrine')->getManager();
        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['email'], 'username' => null ]);

        $token = null;
        $validSocial = false;
        $respSocial = [];


        if ($params['type'] === RedSocialService::FACEBOOK) {

            $respSocial = RedSocialService::validTokenFacebook(['input_token' => $params['token']]);
            $validSocial = (isset($respSocial['data']['is_valid']) ? $respSocial['data']['is_valid'] : false);

            if ($validSocial) {
                $idProvider = explode('|', getenv('FACEBOOK_PROVIDER'));
                $validSocial = ($idProvider[0] === $respSocial['data']['app_id'] ? $validSocial : false) ;
            }

        } else {
            //
        }

        if ($validSocial) {

            if (is_null($user)) {

                $client = new ClientProfile();

                if (isset($params["name"])) {
                    $client->setFullName($params["name"]);
                }

                //$client->setIdentityCard($params["identityCard"]);

                $email = new Email($params['email']);
                $client->setEmail($email->toString());
                $client->setEmailNews(true);

                if (isset($params["mame"])) {
                    $client->setFullName($params["name"]);
                }    

                $redSocial = new RedSocial();
                $params['user_id'] = $respSocial['data']['user_id'];
                $redSocial->updateObject($params, $client);

                $username = \explode('@', $params['email']);
                $username = $username[0];

                $i = 2;
                do {
                    $auxUser = $manager->getRepository(FosUser::class)->findOneByCredentials(['email' => null, 'username' => $username]);
                    if (!is_null($auxUser)) {
                        $username = $username . $i;
                        $i++;
                    }
                } while (!is_null($auxUser));

                $params['username'] = $username;
                $params['password'] = substr(sha1(uniqid(mt_rand(), true)), 0, 8);

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

                $sessions = $manager->getRepository(RedSocial::class)->findBy(['idSocial' => $respSocial['data']['user_id']]);

                if (count($sessions) > 0) {
                    $client = $manager->getRepository(ClientProfile::class)->findOneBy(['user' => $user]);


                    /*  
                        $redSocial = new RedSocial();
                        $params['user_id'] = $respSocial['data']['user_id'];
                        $redSocial->updateObject($params, $client);
                        $manager->persist($client);
                        $manager->persist($redSocial);
                    */   

                } else {
                    throw new NavicuException('User Id not Valid', 400);
                }
            }

            $token = $generator->create($user);
            return ['token' => $token];
        }

        throw new NavicuException('Invalid Token', 400);

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
            'idSocial' => 'required',
            'name' => 'required'
        ];
    }
}        