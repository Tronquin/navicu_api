<?php

namespace App\Navicu\Service;

use App\Entity\EmailRecipient;
use App\Navicu\Exception\NavicuException;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Servicio para envio de correos
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class EmailService
{
    /**
     * Envia un correo
     *
     * @param array $recipients
     * @param string $subject
     * @param string $template
     * @param array $params
     * @return bool
     * @throws NavicuException
     */
    public static function send(array $recipients, string $subject, string $template, array $params = []) : bool
    {
        global $kernel;

        $container = $kernel->getContainer();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../../../.env');

        $mailer = $container->get('swiftmailer.mailer.default');
        $twig = $container->get('twig');
        $from = getenv('MAIL_FROM');

        $message = (new \Swift_Message())
            ->setFrom($from)
            ->setTo($recipients)
            ->setCharset('UTF-8')
            ->setSubject($subject)
            ->setBody($twig->render($template, $params), 'text/html');

        if ($kernel->getEnvironment() === 'dev') {
            return self::printEmail($message);
        }

        return (bool) $mailer->send($message);
    }

    /**
     * Envia un correo donde los destinatarios estan configurados
     * en la tabla email_recipient
     *
     * @param string $emailName
     * @param string $subject
     * @param string $template
     * @param array $params
     * @return bool
     * @throws NavicuException
     */
    public static function sendFromEmailRecipients(string $emailName, string $subject, string $template, array $params) : bool
    {
        global $kernel;
        $container = $kernel->getContainer();

        $manager = $container->get('doctrine')->getManager();
        $to = $manager->getRepository(EmailRecipient::class)->findBy([$emailName => true]);

        if (! $to) {
            throw new NavicuException(sprintf('No recipients configured to email "%s"', $emailName));
        }

        $recipients = [];
        /** @var EmailRecipient $email */
        foreach ($to as $email) {
            $recipients[] = $email->getEmail();
        }

        return self::send($recipients, $subject, $template, $params);
    }

    /**
     * Imprime un log del correo para debug en desarrollo
     *
     * @param \Swift_Message $message
     * @return bool
     */
    private static function printEmail(\Swift_Message $message) : bool
    {
        global $kernel;

        $content = $message->getBody();

        $fs = new Filesystem();
        $now = new \DateTime();

        $filename = $now->format('Y-m-d h:i:s a') . ' ' . $message->getSubject() . rand(1, 99999)  . '.html';
        $path = $kernel->getLogDir() . '/Email/' . $now->format('Y-m-d') . '/' . $filename;

        $fs->dumpFile($path, $content);

        return true;
    }
}