<?php


namespace App\Resolver;


use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserResolver
{
    private $router;
    private const DEFAULT_REFERENCE_TYPE = UrlGeneratorInterface::ABSOLUTE_URL;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function resolveConfirmationUrl(User $user): string
    {
        if (!$user->getConfirmationToken()) {
            throw new \LogicException('A user must have a confirmation token to resolve the confirmation url');
        }

        return $this->router->generate('email.confirm', [
            'confirmationToken' => $user->getConfirmationToken()
        ], self::DEFAULT_REFERENCE_TYPE);
    }
}