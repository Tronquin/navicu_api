<?php

namespace App\Navicu\Handler\Main;

use App\Entity\FosUser;
use App\Entity\Notification;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;

/**
 * Genera una notificacion al usuario
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class NotificationHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->container->get('doctrine')->getManager();
        /** @var FosUser $user */
        $user = $manager->getRepository(FosUser::class)->findOneBy(['email' => $params['email']]);

        if (! $user) {
            throw new NavicuException('User not found');
        }

        $notification = new Notification();
        $notification->setMessage($params['message']);
        $notification->setReciver($user);
        $notification->setType($params['type']);

        $manager->persist($notification);
        $manager->flush();

        return compact('notification');
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
            'message' => 'required',
            'email' => 'required|email',
            'type' => 'required|numeric'
        ];
    }
}