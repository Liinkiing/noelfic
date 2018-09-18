<?php

namespace App\Security\Voter;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentVoter extends Voter
{

    public const DELETE = 'delete';
    public const POST = 'post';

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::DELETE, self::POST], true)
            && $subject instanceof Comment;
    }

    /**
     * @param string $attribute
     * @param Comment $subject
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
                return $this->canDelete($subject, $user);
                break;
            case self::POST:
                return $this->canPost($user);
                break;
        }

        return false;
    }

    private function canDelete(Comment $comment, User $user): bool
    {
        return $user->hasRole('ROLE_ADMIN') ||
            $user->getUsername() === $comment->getAuthor()->getUsername();
    }

    private function canPost(User $user): bool
    {
        return $user->isConfirmed();
    }
}
