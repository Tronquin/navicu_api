<?php

namespace App\Navicu\Contract;

/**
 * Interface PaymentGateway modela las funciones que obligatoriamente deben implementarse un medio de pago implementado por y a traves de terceros
 *
 * @author Javier Vasquez 
 * @version 17-11-2018
 */
interface PaymentGateway
{

     /**
     * las constantes registran los posibles tipos de pagos que admite navicu
     */
    const INSTAPAGO_TDC = 1;
    const NATIONAL_TRANSFER = 2;
    const STRIPE_TDC =3 ;
    const INTERNATIONAL_TRANSFER = 4;
    const AAVV = 5;  
    const PAYEEZY = 6 ;
    const PANDCO_TRANSFER = 7;
    const PAYPAL=8;
 
    /**
     * este metodo toma un conjunto de pagos, los valida y los procesa
     *
     * @author Javier Vasquez 
     * @version 17-11-2018
     * @return  Object | json | array
     */
    public function processPayments($request);


    /**
     * debe validar que todos los campos requeridos para hacer la solicitud esten completos y sean correctos
     *
     */
    public function validateRequestData($request);

    /**
     * debe devolver la data requerida para hacer la solicitud formateada segun los requerimientos de la entidad
     *   
     */
    public function formaterRequestData($request);

    /**
     * debe devolver la data requerida para ser devuelta a el caso de uso segun el formato que necesite
     *  
     */
    public function formaterResponseData($response);


    /**
     * indica si el pago es valido y correcto
     *
    */
    public function isSuccess();

    /**
     *  funcion que devuelve el tipo de pago definido entre las constantes de esta interfaz

     */
    public function getTypePayment();


    /**
     * devuelve un array clave => valor con los estados posibles de el tipo de reservas que implementa
     */
    public function getStates();

  
    /**
     * devuelve el tipo de moneda que maneja la instancia de paymentgateway
     */
    public function getCurrency();


    /**
     * devuleve la antelacion por defecto para el tipo de pago
     */
    public function getCutOff();
}