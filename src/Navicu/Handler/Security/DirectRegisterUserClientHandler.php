<?php

namespace App\Navicu\Handler\Security;

use App\Entity\FosUser;
use App\Entity\ClientProfile;
use App\ClassEfect\ValueObject\Email;
use App\ClassEfect\ValueObject\Phone;
use App\Navicu\Handler\BaseHandler;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Service\EmailService;
/**
 * Registra un nuevo usuario, si no recibe username asigna uno del email,
 * si no resibe password se crea una clave aleatoria
 *
 * @author Javier Vasquez <jvasquez@jacidi.com>
 */
class DirectRegisterUserClientHandler extends BaseHandler
{
    /**
     * @return array
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();


        $username = isset($params['username']) ? $params['username'] : null;
        $user = $manager->getRepository(FosUser::class)->findOneByCredentials([ 'email' => $params['email'], 'username' => $username ]);

        if (! empty($user)) {
            throw new NavicuException('User Exist', 400, ['email' => $params['email'], 'username' => $username]);
        }
       
        $encoder = $params['encoder'];
        $generator = $params['generator'];
       
        $user = new FosUser();

        if (! isset($params['username'])) {
            $username = \explode('@', $params['email']);
            $username = $username[0];
            $i = 2;

            do {
                $auxUser = $manager->getRepository(FosUser::class)->findOneBy(["username" => $username]);
                if (!is_null($auxUser)) {
                    $username = $username . $i;
                    $i++;
                }
            } while (!is_null($auxUser));

            $params['username'] = $username;
        }
        $user->updateObject($params, $encoder);

        $client = new ClientProfile();

        if (isset($params["fullName"])) {
            $client->setFullName($params["fullName"]);
        } else {
           if(isset($params["firstName"])) {
               $client->setFullName($params["firstName"].' '.$params["lastName"]);
           } else {
               $client->setFullName($params["username"]);
           }
        }

        if (isset($params["identityCard"])) {
            $client->setIdentityCard($params["identityCard"]);
        }

        $email = new Email($params['email']);
        $client->setEmail($email->toString());

        $country = isset($params["country"]) ? $params["country"]: 1;
        $state = isset($params["state"]) ? $params["state"]: null;
        $client->setCountry($country);
        $client->setState($state);

        if (isset($params["typeIdentity"]))
            $client->setTypeIdentity($params["typeIdentity"]);

        if (isset($params['state'])) {
            $location = $manager->getRepository(Location::class)->findOneBy(['id' => $params['state']]);
            if ($location)
                $client->setLocation($location);
        }

        if (isset($params["gender"])) {
                $client->setGender($params["gender"]);
        }           

        if (isset($params["phone"])) {
            $phone = new Phone($params["phone"]);
            $client->setPhone($phone->toString());
        }
            
        if (isset($params["birthDate"])) {   
            $client->setBirthdate($params["birthDate"]);
        }
      
        $client->setEmailNews(true);        
        $client->setUser($user);

        $manager->persist($user);
        $manager->persist($client);
        $manager->flush();

        $this->sendEmailData($client, $user);

        $token = $generator->create($user);
       
        return ['token' => $token];
    }

    public function sendEmailData(ClientProfile $client, FosUser $user)
    {
        $dataEmail['user'] = $client->getUser();
        $dataEmail['email'] = $client->getEmail();
        $dataEmail['password'] = $user->getPlainPassword();
        $dataEmail['fullName'] = $client->getFullName();
        $dataEmail['generatedPassword'] = isset($params['password']) ? false : true;

        EmailService::send(
            [$dataEmail['email']],
            'Bienvenido a navicu.com - Datos del registro',
            'Email/Security/singInClient.html.twig',
            $dataEmail
        );
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
            'email' => 'required'
        ];
    }
}        