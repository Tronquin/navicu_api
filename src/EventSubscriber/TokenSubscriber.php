<?php

namespace App\EventSubscriber;

use App\Entity\OauthUser;
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
    
      if (! $request->headers->has('token')) {

            return $event->setController(function () {
                return new JsonResponse(['code' => 400, 'errors' => ['token is required']], 400);
            });
        }

        $manager = $this->container->get('doctrine')->getManager();
        $token = $request->headers->get('token');


        $oAuthUser = $manager->getRepository(OauthUser::class)->findOneBy(['token' => $token]);

        if (! $oAuthUser) {

            return $event->setController(function () {
                return new JsonResponse(['code' => 400, 'errors' => ['token not found']], 400);
            });
        }

        $now = new \DateTime();
        $expiredAt = $oAuthUser->getExpiredAt();

        if ($now > $expiredAt) {

            return $event->setController(function () {
                return new JsonResponse(['code' => 400, 'errors' => ['token expired']], 400);
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