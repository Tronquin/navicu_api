<?php

namespace App\Navicu\Service;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Servicio para traducciones
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class Translator
{
    /**
     * @var TranslatorInterface
     */
    private static $translator = null;

    /**
     * Traduce un texto
     *
     * @param string $message
     * @param array $params
     * @return string
     */
    public static function trans(string $message, array $params = [])
    {
        self::initTranslator();

        return self::$translator->trans($message, $params);
    }

    /**
     * Inicializa el traductor de forma controlada para
     * no inicializar al servicio de symfony consecutivamente
     */
    private static function initTranslator()
    {
        if (! (self::$translator instanceof TranslatorInterface)) {

            global $kernel;
            self::$translator = $kernel->getContainer()->get('translator');
        }
    }
}