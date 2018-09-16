<?php


namespace App\GraphQL\Mutation\Fiction\Chapter;


use App\Entity\FictionChapterComment;
use App\Entity\User;
use App\Repository\FictionChapterCommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;

class AddFictionChapterCommentMutation implements MutationInterface
{

    private $repository;
    private $entityManager;

    public function __construct(FictionChapterCommentRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Argument $args, User $viewer)
    {
        [$commentId, $body] = [$args->offsetGet('commentId'), $args->offsetGet('body')];

        if ($comment = $this->repository->find($commentId)) {
            $answer = (new FictionChapterComment())
                ->setChapter($comment->getChapter())
                ->setBody($body)
                ->setAuthor($viewer);
            $comment->addChild($answer);
            $this->entityManager->flush();

            return ['fictionChapterComment' => $answer];
        }

        throw new UserError('Comment not found');

    }

}