<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Translation\TranslatorInterface;

class SecuritySubscriber implements EventSubscriberInterface
{
    private $flashBag;
    private $tokenManager;
    private $router;

    public function __construct(FlashBagInterface $flashBag,
                                CsrfTokenManagerInterface $tokenManager,
                                RouterInterface $router)
    {
        $this->flashBag = $flashBag;
        $this->tokenManager = $tokenManager;
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();
        if (!$user->isConfirmed()) {
            $this->flashBag->add('warning', [
                'id' => 'flash.user.email.not_confirmed',
                'parameters' => [
                    '{token}' => $this->tokenManager->getToken('token'),
                    '{confirmationUrl}' => $this->router->generate('email.send_confirmation')
                ]
            ]);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        ];
    }
}
