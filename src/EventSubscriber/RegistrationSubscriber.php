<?php

namespace App\EventSubscriber;

use App\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class RegistrationSubscriber implements EventSubscriberInterface
{
    private $flashBag;
    private $tokenStorage;
    private $dispatcher;
    private $session;

    public function __construct(
        FlashBagInterface $flashBag,
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $dispatcher,
        SessionInterface $session
    ) {
        $this->flashBag = $flashBag;
        $this->tokenStorage = $tokenStorage;
        $this->dispatcher = $dispatcher;
        $this->session = $session;
    }

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $this->flashBag->add('success', 'flashes.registration.successful');
        $this->authenticateUser($event->getRequest(), $event->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
           UserRegisteredEvent::NAME => 'onUserRegistered',
        ];
    }

    protected function authenticateUser(Request $request, UserInterface $user, string $provider = 'main'): void
    {
        $token = new UsernamePasswordToken($user, null, $provider, $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set("_security_$provider", \serialize($token));
        $this->dispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, new InteractiveLoginEvent($request, $token));
    }

}
