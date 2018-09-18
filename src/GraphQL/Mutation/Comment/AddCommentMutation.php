<?php


namespace App\GraphQL\Mutation\Comment;


use App\Entity\Fiction;
use App\Entity\FictionChapter;
use App\Entity\FictionChapterComment;
use App\Entity\FictionComment;
use App\Entity\User;
use App\Repository\FictionChapterRepository;
use App\Repository\FictionRepository;
use App\Security\Voter\CommentVoter;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AddCommentMutation implements MutationInterface
{

    private $entityManager;
    private $fictionRepository;
    private $fictionChapterRepository;
    private $checker;

    public function __construct(
        FictionRepository $fictionRepository,
        FictionChapterRepository $fictionChapterRepository,
        EntityManagerInterface $entityManager,
        AuthorizationCheckerInterface $checker
    )
    {
        $this->entityManager = $entityManager;
        $this->fictionRepository = $fictionRepository;
        $this->fictionChapterRepository = $fictionChapterRepository;
        $this->checker = $checker;
    }

    public function __invoke(Argument $args, User $viewer)
    {
        [$relatedId, $body] = [$args->offsetGet('relatedId'), $args->offsetGet('body')];

        $related = $this->fictionRepository->find($relatedId);

        if (!$related) {
            $related = $this->fictionChapterRepository->find($relatedId);
        }

        if (!$related) {
            throw new UserError('Could not find related entity');
        }

        if ($related instanceof Fiction) {
            $comment = new FictionComment();
        } elseif ($related instanceof FictionChapter) {
            $comment = new FictionChapterComment();
        } else {
            throw new \RuntimeException('Invalid related type');
        }

        if (!$this->checker->isGranted([CommentVoter::POST], $comment)) {
            throw new UserError('errors.comment.post_forbidden');
        }

        $comment
            ->setBody($body)
            ->setAuthor($viewer);

        $related->addComment($comment);
        $this->entityManager->flush();

        return ['comment' => $comment];
    }

}