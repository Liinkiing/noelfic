<?php


namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class UserRegisteredEvent extends Event
{
    private $user;
    private $request;

    public const NAME = 'user.registered';

    public function __construct(Request $request, User $user)
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}