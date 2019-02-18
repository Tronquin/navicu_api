<?php

namespace App\Navicu\Handler\Flight;

use App\Entity\CurrencyType;
use App\Entity\NvcBank;
use App\Navicu\Handler\BaseHandler;
use App\Navicu\Exception\NavicuException;
/**
 * Obtiene listado de cuentas bancarias
 *
 * @author Javier Vasquez <jvasquez@gmail.com>
 */
class ListBankHandler extends BaseHandler
{
    /**
     * Handler que retorna un listado de bancos deacuerdo a la moneda de la reserva
     *
     * @return array
     * @throws NavicuException
     */
    protected function handler() : array
    {
        $manager = $this->container->get('doctrine')->getManager();
        $params = $this->getParams();

        $currency = $manager->getRepository(CurrencyType::class)->findOneBy(['alfa3' => $params['currency']]);
        $nvcBankList = $manager->getRepository(NvcBank::class)->findByCurrency($currency);

        foreach ($nvcBankList as $nvcBank) {
            if ($nvcBank->getId() !== 2) {
                $receptors[] = [
                    'name' => $nvcBank->getName(),
                    'account_number' => $nvcBank->getAccountNumber(),
                    'billing_name' => $nvcBank->getBillingName(),
                    'billing_email' => $nvcBank->getBillingEmail(),
                    'cable_code' => $nvcBank->getCableCode(),
                    'swift_code' => $nvcBank->getSwiftCode(),
                    'routing_number' => $nvcBank->getRoutingNumber(),
                    'rif_code' => $nvcBank->getRifCode(),
                    'billing_address' => $nvcBank->getBillingAddress()
                ];
                $emisors[] = [
                    'name' => $nvcBank->getName(),
                ];
            }
        }

        $response['receptors'] = $receptors ?? [];
        $response['emisors'] = $emisors ?? [];

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
        return [
            'currency' => 'required|regex:/^[A-Z]{3}/'
        ];
    }
}