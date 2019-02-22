<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTempPayment;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Service\EmailService;

/**
 * Confirma el pago de un paquete
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ConfirmPaymentPackageHandler extends BaseHandler
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

        /** @var PackageTempPayment $payment */
        $payment = $manager->getRepository(PackageTempPayment::class)->find($params['paymentId']);

        if (! $payment) {
            throw new NavicuException('Payment Package not found');
        }

        $content = json_decode($payment->getContent(), true);
        $payment->setStatus(PackageTempPayment::STATUS_ACCEPTED);

        // Descuenta la disponibilidad del paquete
        $package = $payment->getPackageTemp();
        $package->setAvailability($package->getAvailability() - 1);

        $manager->flush();

        // Enviar correo al departamento comercial
        EmailService::send(['mcontreras@navicu.com', 'eblanco@navicu.com'],
            'Navicu - Pago de paquete carnaval',
            'Email/Carnival/reservation.html.twig',
            [
                'package' => json_decode($package->getContent(), true),
                'packagePayment' => json_decode($payment->getContent(), true)
            ]
        );

        $recipients = array_map(function ($p) {
            return $p['email'];
        }, $content['passengers']);

        // Correo al cliente
        EmailService::send($recipients,
            'Navicu - Pago de paquete carnaval',
            'Email/Carnival/reservation.html.twig',
            [
                'package' => json_decode($package->getContent(), true),
                'packagePayment' => json_decode($payment->getContent(), true)
            ]
        );

        return compact('payment');
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
            'paymentId' => 'required|numeric'
        ];
    }
}