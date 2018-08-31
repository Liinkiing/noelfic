<?php


namespace App\Event;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRegisteredEvent extends Event
{
    private $user;
    private $request;

    public const NAME = 'user.registered';

    public function __construct(Request $request, UserInterface $user)
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}