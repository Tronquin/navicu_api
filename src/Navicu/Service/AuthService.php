<?php

namespace App\Navicu\Service;

use App\Entity\FosUser;

/**
 * Maneja informacion de usuario autenticado
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class AuthService
{
    /**
     * @var FosUser $user
     */
    private static $user = null;

    /**
     * Guarda usuario autenticado
     *
     * @param FosUser $user
     */
    public static function setUser(FosUser $user)
    {
        self::$user = $user;
    }

    /**
     * Obtiene usuario autenticado
     *
     * @return FosUser
     */
    public static function getUser(): FosUser
    {
        return self::$user;
    }

    /**
     * Indica si el usuario esta autenticado
     *
     * @return bool
     */
    public static function isAuth()
    {
        return !! self::$user;
    }
}