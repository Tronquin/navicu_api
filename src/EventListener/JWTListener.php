<?php

namespace App\EventListener;

use Psr\Container\ContainerInterface;
use App\Entity\FosUser;
use App\Entity\ClientProfile;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTEncodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

class JWTListener {
	/**
	 * @var RequestStack
	 */
	private $requestStack;

	private $container;

	/**
	 * @param RequestStack $requestStack
	 */
	public function __construct(RequestStack $requestStack, ContainerInterface $container)
	{
	    $this->requestStack = $requestStack;
	    $this->container = $container;
	}

	/**
	 * @param JWTCreatedEvent $event
	 *
	 * @return void
	 */
	public function onJWTCreated(JWTCreatedEvent $event)
	{
	   $request = $this->requestStack->getCurrentRequest();
	    
	    $user = $event->getUser();

	    $manager = $this->container->get('doctrine')->getManager();
        $clientProfile = $manager->getRepository(ClientProfile::class)->findOneBy([ 'user' => $user ]);

        if (! empty($clientProfile)) {
		    $payload       = $event->getData();
			$payload['name'] = $clientProfile->getFullName();
		   	$payload['email'] = $user->getEmail();
		    $event->setData($payload);	  
	    }  
	    //$header        = $event->getHeader();
	    //$header['cty'] = 'JWT';
	    //$event->setHeader($header);
	}


	/**
	 * @param JWTEncodedEvent $event
	 */
	public function onJwtEncoded(JWTEncodedEvent $event)
	{
		/*$request = $this->requestStack->getCurrentRequest();		

		$em = $this->container->get('doctrine')->getManager();

	    $token = $event->getJWTString();

	    $data =  $this->container->get('lexik_jwt_authentication.encoder')->decode($token);

	    $user = $em->getRepository(FosUser::class)->findOneBy(['username' => $data['username']]);

	    $user->setConfirmationToken($token);
	
		$em->persist($user);
		$em->flush();
	    */
	}


	/**
	 * @param JWTDecodedEvent $event
	 *
	 * @return void
	 */
	public function onJWTDecoded(JWTDecodedEvent $event)
	{
	   /* $request = $this->requestStack->getCurrentRequest();
	    
	    $payload = $event->getPayload();

	    $expiration = new \DateTime('+1000000 second');
    	$expiration->setTime(2, 0, 0);

    	$payload['exp'] = $expiration->getTimestamp();

    	$event->setPayload($payload);

	    if (!isset($payload['ip']) || $payload['ip'] !== $request->getClientIp()) {
	        $event->markAsInvalid();
	    }
	   */
	}


}