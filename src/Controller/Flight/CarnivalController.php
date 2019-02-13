<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Carnival\PackageListHandler;
use App\Navicu\Handler\ProcessPaymentPackageHandler;
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
     * @Route("/package_list", name="flight_carnival_package_list")
     *
     * @return JsonResponse
     */
    public function packageList()
    {
        $handler = new PackageListHandler();
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Procesa el pago del paquete
     *
     * @Route("/package_list", name="flight_carnival_package_list")
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
