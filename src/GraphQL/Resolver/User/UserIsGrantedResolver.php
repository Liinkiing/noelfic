<?php

namespace App\GraphQL\Resolver\User;


use App\Entity\User;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserIsGrantedResolver implements ResolverInterface
{

    private const ROLES_WHITELIST = ['ROLE_ADMIN'];

    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function isGranted($user, $userRequest): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        $token = $this->token->getToken();
        if (!$token) {
            return false;
        }

        foreach (self::ROLES_WHITELIST as $role) {
            if ($user->hasRole($role)) {
                return true;
            }
        }

        if ($userRequest && $userRequest instanceof User) {
            return $user->hasRole('ROLE_USER') && $user->getId() === $userRequest->getId();
        }

        if ($user->hasRole('ROLE_USER') && $user->getId() === $token->getUser()->getId()) {
            return true;
        }

        return false;

    }

}