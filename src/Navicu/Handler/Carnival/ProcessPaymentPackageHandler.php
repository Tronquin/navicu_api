<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\PackageTemp;
use App\Entity\PackageTempPayment;
use App\Navicu\Contract\PaymentGateway;
use App\Navicu\Exception\NavicuException;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Handler\Main\PayHandler;
use App\Navicu\Service\EmailService;

/**
 * Procesa el pago del paquete
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class ProcessPaymentPackageHandler extends BaseHandler
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

        /** @var PackageTemp $package */
        $package = $manager->getRepository(PackageTemp::class)->find($params['packageId']);

        if (! $package) {
            throw new NavicuException('Package not found');
        }

        if ($package->getAvailability() <= 0 || $params['general']['quantity'] > $package->getAvailability()) {
            throw new NavicuException('Package not available', self::CODE_NOT_AVAILABILITY, [
                'availability' => $package->getAvailability()
            ]);
        }

        // Procesa el pago
        $handler = new PayHandler();
        $handler->setParam('paymentType', $params['paymentType']);
        $handler->setParam('currency', $params['currency']);
        $handler->setParam('payments', $params['payments']);
        $handler->processHandler();

        if (! $handler->isSuccess()) {
            $this->addErrorToHandler($handler->getErrors()['errors']);

            throw new NavicuException('Payment fail', $handler->getErrors()['code'], $handler->getErrors()['params']);
        }

        // Registra el pago
        $packagePayment = new PackageTempPayment();
        $packagePayment->setContent(json_encode([
            'general' => $params['general'],
            'payments' => $params['payments'],
            'passengers' => $params['passengers'],
            'response' => $handler->getData()['data']['responsePayments']
        ]));
        $packagePayment->setPackageTemp($package);

        if (
            PaymentGateway::INTERNATIONAL_TRANSFER === $params['paymentType'] ||
            PaymentGateway::NATIONAL_TRANSFER === $params['paymentType']
        ) {
            // En caso de transferencia
            $packagePayment->setStatus(PackageTempPayment::STATUS_IN_PROCESS);
            $recipients = ['ocoronel@navicu.com'];

        } else {
            // Pago TDC
            $packagePayment->setStatus(PackageTempPayment::STATUS_ACCEPTED);

            // Descuenta la disponibilidad del paquete
            $packagePayment->setPackageTemp($package);
            $package->setAvailability($package->getAvailability() - 1);

            $recipients = ['mcontreras@navicu.com', 'eblanco@navicu.com'];
        }

        $manager->persist($packagePayment);
        $manager->flush();

        // Las pre-reservas se les notifican a finanzas y los pagos aprobados a comercial
        EmailService::send($recipients,
            'Navicu - Pago de paquete carnaval',
            'Email/Flight/carnivalPaymentReservation.html.twig',
            [
                'package' => json_decode($package->getContent(), true),
                'passengers' => $params['passengers'],
                'general' => $params['general']
            ]
        );

        return compact('package');
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
            'packageId' => 'required|numeric',
            'payments' => 'required',
            'paymentType' => 'required|numeric|between:1,8',
            'currency' => 'required|regex:/^[A-Z]{3}$/',
            'passengers' => 'required',
            'general' => 'required'
        ];
    }
}