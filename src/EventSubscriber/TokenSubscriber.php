<?php

namespace App\EventSubscriber;

use App\Entity\OAuthUser;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if (! $request->query->has('token')) {

            return $event->setController(function () {
                return new JsonResponse(['code' => 400, 'errors' => ['token is required']]);
            });
        }

        $manager = $this->container->get('doctrine')->getManager();
        $token = $request->get('token');

        /** @var OAuthUser $oAuthUser */
        $oAuthUser = $manager->getRepository(OAuthUser::class)->findOneBy(['token' => $token]);

        if (! $oAuthUser) {

            return $event->setController(function () {
                return new JsonResponse(['code' => 400, 'errors' => ['token not found']]);
            });
        }

        $now = new \DateTime();
        $expiredAt = $oAuthUser->getExpiredAt();

        if ($now > $expiredAt) {

            return $event->setController(function () {
                return new JsonResponse(['code' => 400, 'errors' => ['token expired']]);
            });
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }
}