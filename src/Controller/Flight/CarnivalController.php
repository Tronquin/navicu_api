<?php

namespace App\Controller\Flight;

use App\Navicu\Handler\Carnival\ConfirmPaymentPackageHandler;
use App\Navicu\Handler\Carnival\PackageAvailabilityListHandler;
use App\Navicu\Handler\Carnival\PackageListHandler;
use App\Navicu\Handler\Carnival\PaymentPackageListHandler;
use App\Navicu\Handler\Carnival\ProcessPaymentPackageHandler;
use App\Navicu\Handler\Carnival\UpdatePackageAvailabilityHandler;
use App\Navicu\Handler\Flight\IsTransferActiveHandler;
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
     * Obtiene un listado de los paquetes de carnaval con disponibilidad mayor a 0
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
     * Lista todos los paquetes
     *
     * @Route("/package_availability", name="flight_carnival_list_availability", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function packageAvailability()
    {
        $handler = new PackageAvailabilityListHandler();
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Actualiza la disponibilidad de un paquete
     *
     * @Route("/package_availability", name="flight_carnival_update_availability", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePackageAvailability(Request $request)
    {
        $handler = new UpdatePackageAvailabilityHandler($request);
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
     * Lista de todos los pagos de paquetes, filtra por estatus
     *
     * @Route("/payment_package_list", name="flight_carnival_payment_package_list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paymentPackageList(Request $request)
    {
        $handler = new PaymentPackageListHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Confirma el pago de un paquete
     *
     * @Route("/payment_package_confirm/{paymentId}", name="flight_carnival_payment_package_confirm", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function paymentConfirm(Request $request)
    {
        $handler = new ConfirmPaymentPackageHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }

    /**
     * Verifica si esta activa la opcion transferencia
     *
     * @Route("/is_transfer_active/{provider}", name="flight_carnival_is_transfer_active", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function isTransferActive(Request $request)
    {
        $handler = new IsTransferActiveHandler($request);
        $handler->processHandler();

        return $handler->getJsonResponseData();
    }
}
