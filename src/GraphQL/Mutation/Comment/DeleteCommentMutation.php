<?php


namespace App\GraphQL\Mutation\Comment;


use App\Repository\CommentRepository;
use App\Security\Voter\CommentVoter;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DeleteCommentMutation implements MutationInterface
{

    private $repository;
    private $entityManager;
    private $voter;

    public function __construct(
        CommentRepository $repository,
        EntityManagerInterface $entityManager,
        AuthorizationCheckerInterface $voter)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->voter = $voter;
    }

    public function __invoke(Argument $args)
    {
        $comment = $this->repository->find($args->offsetGet('commentId'));

        if (!$comment) {
            throw new \RuntimeException('Comment not found');
        }

        if ($this->voter->isGranted([CommentVoter::DELETE], $comment)) {
            $deletedCommentId = $comment->getId();
            $this->entityManager->remove($comment);
            $this->entityManager->flush();

            return compact('deletedCommentId');
        }

        throw new UserError('You cant delete another comment');
    }
}