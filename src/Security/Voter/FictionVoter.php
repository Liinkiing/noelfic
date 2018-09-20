<?php

namespace App\Security\Voter;

use App\Entity\Fiction;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class FictionVoter extends Voter
{
    public const EDIT = 'edit';
    public const ADD = 'ADD';

    protected function supports($attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return \in_array($attribute, [self::EDIT, self::ADD], true)
            && $subject instanceof Fiction;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::ADD:
                return $this->canAdd($user);
        }

        return false;
    }

    private function canAdd(User $user): bool
    {
        return $user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_WRITER');
    }

    private function canEdit(Fiction $fiction, User $user): bool
    {
        return $user->hasRole('ROLE_ADMIN') ||
            \in_array($user->getId(), array_map(function (User $author) {
                return $author->getId();
            }, $fiction->getAuthors()), true);
    }
}
