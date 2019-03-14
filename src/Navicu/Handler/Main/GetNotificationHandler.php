<?php

namespace App\Navicu\Handler\Main;

use App\Entity\Notification;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\AuthService;
use App\Navicu\Service\Translator;

/**
 * Obtiene las notificaciones sin leer de un usuario
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class GetNotificationHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();

        if (! AuthService::isAuth()) {
            throw new NavicuException('User not found');
        }

        $user = AuthService::getUser();
        $notifications = $manager->getRepository(Notification::class)->findBy([
            'view' => false,
            'reciver' => $user->getId()
        ]);
        $response = [];

        /** @var Notification $notification */
        foreach ($notifications as $notification) {
            $response[] = [
                'type' => $notification->getType(),
                'message' => Translator::trans($notification->getMessage()),
            ];
        }

        return $response;
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
        return [];
    }
}