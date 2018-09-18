<?php


namespace App\GraphQL\Mutation\Comment;


use App\Entity\FictionChapterComment;
use App\Entity\FictionComment;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Security\Voter\CommentVoter;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AddAnswerCommentMutation implements MutationInterface
{

    private $repository;
    private $entityManager;
    private $checker;

    public function __construct(CommentRepository $repository, EntityManagerInterface $entityManager, AuthorizationCheckerInterface $checker)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->checker = $checker;
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

            if(!$this->checker->isGranted([CommentVoter::POST], $answer)) {
                throw new UserError('errors.comment.answer_forbidden');
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