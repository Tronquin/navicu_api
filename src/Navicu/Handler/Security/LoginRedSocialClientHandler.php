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
 * Registra un usuario por red social
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
        $encoder = $this->container->get('security.password_encoder');;
        $generator = $this->container->get('lexik_jwt_authentication.jwt_manager');
        
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../../.env');

        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['email'], 'username' => null ]);

        $token = null;
        $validSocial = false;
        $respSocial = [];

        if ($params['type'] === RedSocialService::FACEBOOK) {

            $respSocial = RedSocialService::validTokenFacebook(['input_token' => $params['token'], 'user_id' => $params['idSocial']]);
            $validSocial = (isset($respSocial['data']['is_valid']) ? $respSocial['data']['is_valid'] : false);

            if ($validSocial) {
                $validSocial = false;
                $idProvider = explode('|', getenv('FACEBOOK_PROVIDER'));
                
                if ($idProvider[0] === $respSocial['data']['app_id']) {
                    $dataUserSocial = RedSocialService::getDataFacebook(['input_token' => $params['token'], 'user_id' => $params['idSocial']]);
              
                    $validSocial = (isset($dataUserSocial['email']) && $params['email'] === $dataUserSocial['email'] ? true : false); 
                } else{
                    throw new NavicuException('Invalid  Provider', 403);
                }
            } else {
                throw new NavicuException('Invalid  Token', 403);
            }

        } else if ($params['type'] === RedSocialService::GOOGLE) {

            $respSocial = RedSocialService::getDataGoogle(['access_token' => $params['token']]);
            $validSocial = isset($respSocial['email']) && ($params['email'] === $respSocial['email']) && $respSocial['verified_email'] ? true : false; 

        } else {
            throw new NavicuException('Invalid Red Social Type', 400);
        }

        if (! $validSocial) {
            throw new NavicuException('Invalid User Email', 403);

        } else if (is_null($user)) {            

            $client = new ClientProfile();

            if (isset($params["name"])) {
                $client->setFullName($params["name"]);
            }

            $email = new Email($params['email']);
            $client->setEmail($email->toString());
            $client->setEmailNews(true);

            if (isset($params["mame"])) {
                $client->setFullName($params["name"]);
            }    

            $redSocial = new RedSocial();
            $params['user_id'] = $params['idSocial'];
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
            $user->updateObject($params, $encoder);

            $client->setUser($user);
            $manager->persist($user);
            $manager->persist($client);
            $manager->persist($redSocial);
            $manager->flush();
        }

        if (! empty($user)) {
            $token = $generator->create($user);
            return ['token' => $token];
        } 
        
        throw new NavicuException('User not Found', 400);        

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
            'type' => 'required',
            'token' => 'required',
            'idSocial' => 'required',
            'name' => 'required'
        ];
    }
}        