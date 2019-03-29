<?php

namespace App\Navicu\Handler\Carnival;

use App\Entity\CurrencyType;
use App\Entity\PackageTempPayment;
use App\Navicu\Handler\BaseHandler;

/**
 * Lista todos los pagos de paquetes para un estatus
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class PaymentPackageListHandler extends BaseHandler
{

    /**
     * Aqui va la logica
     *
     * @return array
     */
    protected function handler() : array
    {
        $params = $this->getParams();
        $manager = $this->getDoctrine()->getManager();
        $status = $params['status'] ?? null;
        $payments = $manager->getRepository(PackageTempPayment::class)->findByStatus($status);
        $currencyRepository = $manager->getRepository(CurrencyType::class);

        $payments = array_map(function (PackageTempPayment $payment) use ($currencyRepository) {

            $dataPayment = json_decode($payment->getContent(), true);
            $dataGeneral = json_decode($payment->getPackageTemp()->getContent(), true);
            /** @var CurrencyType $currency */
            $currency = $currencyRepository->findOneBy(['alfa3' => $dataPayment['payments'][0]['currency']]);
            $data['status'] = $payment->getStatus();
            $data['title'] = $dataGeneral['title'] . '-' .$dataGeneral['subtitle'];
            $data['name'] = $dataPayment['passengers'][0]['title'] . ' ' . $dataPayment['passengers'][0]['fullName'];
            $data['email'] = $dataPayment['passengers'][0]['email'];
            $data['documentNumber'] = $dataPayment['passengers'][0]['documentNumber'];
            $data['phone'] = $dataPayment['passengers'][0]['phone'];
            $data['currency'] = $currency->getAlfa3();
            $data['symbol'] = $currency->getSimbol();
            $data['price'] = $dataPayment['payments'][0]['amount'];
            $data['start'] = $dataPayment['general']['start'];
            $data['end'] = $dataPayment['general']['end'];
            $data['quantity'] = $dataPayment['general']['quantity'];
            $data['paymentType'] = $dataPayment['payments'][0]['paymentType'];
            $data['package'] = $dataGeneral;
            $data['confirmationId'] = $dataPayment['payments'][0]['confirmationId'] ?? null;
            $data['bank'] = $dataPayment['payments'][0]['bank'] ?? null;
            $data['receivingBank'] = $dataPayment['payments'][0]['receivingBank'] ?? null;
            $data['publicId'] = $dataPayment['publicId'];
            $data['id'] = $payment->getId();

            return $data;

        }, $payments);

        return $payments;
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
            'status' => 'in:1,2,3,4'
        ];
    }
}