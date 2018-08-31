<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class SecuritySubscriber implements EventSubscriberInterface
{
    private $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();
        if (!$user->isConfirmed()) {
            $this->flashBag->add('warning', 'flash.user.email_not_confirmed');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
           SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        ];
    }
}
