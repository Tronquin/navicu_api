<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Carnival\PackageListHandler;
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
     * @Route("/package_list/{currency}", name="flight_carnival_package_list")
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
}
