<?php


namespace App\GraphQL\Mutation\Comment;


use App\Entity\FictionChapterComment;
use App\Entity\FictionComment;
use App\Entity\User;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class AddAnswerCommentMutation implements MutationInterface
{

    private $repository;
    private $entityManager;

    public function __construct(CommentRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Argument $args, User $viewer)
    {
        [$commentId, $body] = [$args->offsetGet('commentId'), $args->offsetGet('body')];

        if ($comment = $this->repository->find($commentId)) {
            if ($comment instanceof FictionChapterComment) {
                $answer = (new FictionChapterComment())->setChapter($comment->getChapter());
            } else if ($comment instanceof FictionComment) {
                $answer = (new FictionComment())->setFiction($comment->getFiction());
            } else {
                throw new \RuntimeException('Invalid comment type');
            }
            $answer
                ->setBody($body)
                ->setAuthor($viewer);
            $comment->addChild($answer);
            $this->entityManager->flush();

            return ['comment' => $answer];
        }

        throw new UserError('Comment not found');

    }

}