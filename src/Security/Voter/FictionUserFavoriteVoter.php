<?php

namespace App\Security\Voter;

use App\Entity\FictionUserFavorite;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class FictionUserFavoriteVoter extends Voter
{

    public const DELETE = 'delete';
    public const ADD = 'add';

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::DELETE, self::ADD], true)
            && $subject instanceof FictionUserFavorite;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($user);
                break;
            case self::ADD:
                return $this->canAdd($user);
                break;
        }

        return false;
    }

    private function canDelete(User $user): bool
    {
        return $user->isConfirmed();
    }

    private function canAdd(User $user): bool
    {
        return $user->isConfirmed();
    }
}
