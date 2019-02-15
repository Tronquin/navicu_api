<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Carnival\ConfirmPaymentPackageHandler;
use App\Navicu\Handler\Carnival\PackageListHandler;
use App\Navicu\Handler\Carnival\PaymentPackageListHandler;
use App\Navicu\Handler\Carnival\ProcessPaymentPackageHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/carnival")
 */
class CarnivalController extends AbstractController
{
    /**
     * Obtiene un listado de los paquetes de carnaval
     *
     * @Route("/package_list/{currency}", name="flight_carnival_package_list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function packageList(Request $request)
    {
        $handler = new PackageListHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Procesa el pago del paquete
     *
     * @Route("/payment_package", name="flight_carnival_payment_package", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paymentPackage(Request $request)
    {
        $handler = new ProcessPaymentPackageHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Lista de pagos pendientes
     *
     * @Route("/payment_package_pending", name="flight_carnival_payment_package_pending", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function paymentList()
    {
        $handler = new PaymentPackageListHandler();
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Confirma el pago de un paquete
     *
     * @Route("/payment_package_confirm/{paymentId}", name="flight_carnival_payment_package_confirm", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function paymentConfirm(Request $request)
    {
        $handler = new ConfirmPaymentPackageHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
