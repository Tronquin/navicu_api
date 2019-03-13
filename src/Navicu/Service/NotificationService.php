<?php

namespace App\Navicu\Service;

use App\Entity\FosUser;
use App\Entity\Notification;

/**
 * Crea notificaciones en el sistema
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class NotificationService
{
    /**
     * Crea una notificacion
     *
     * @param string $message
     * @param int $type
     * @param FosUSer $user
     */
    public static function notify(string $message, int $type, ?FosUser $user = null)
    {
        global $kernel;
        $manager = $kernel->getContainer()->get('doctrine')->getManager();

        $notification = new Notification();
        $notification->setMessage($message);
        $notification->setType($type);
        $notification->setSender(null);
        $notification->setData(null);
        $notification->setDate(new \DateTime());
        $notification->setView(false);

        if (! $user && AuthService::isAuth()) {
            // En caso que no indicar usuario, se verifica si existe alguna sesion iniciada
            $user = AuthService::getUser();
        }

        $notification->setReciver($user);

        $manager->persist($notification);
        $manager->flush();
    }

    /**
     * Crea una notificacion de confirmacion
     *
     * @param string $message
     * @param FosUSer $user
     */
    public static function notifyConfirm(string $message, ?FosUser $user = null)
    {
        self::notify($message, Notification::TYPE_CONFIRM, $user);
    }

    /**
     * Crea una notificacion de Pre
     *
     * @param string $message
     * @param FosUSer $user
     */
    public static function notifyPre(string $message, ?FosUser $user = null)
    {
        self::notify($message, Notification::TYPE_PRE, $user);
    }

    /**
     * Crea una notificacion de cancelacion
     *
     * @param string $message
     * @param FosUSer $user
     */
    public static function notifyCancel(string $message, ?FosUser $user = null)
    {
        self::notify($message, Notification::TYPE_CANCEL, $user);
    }
}