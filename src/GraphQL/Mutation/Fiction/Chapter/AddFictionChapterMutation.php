<?php


namespace App\GraphQL\Mutation\Fiction\Chapter;


use App\Entity\FictionChapter;
use App\Entity\User;
use App\GraphQL\Exception\AppGraphQLException;
use App\Repository\FictionCategoryRepository;
use App\Repository\FictionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddFictionChapterMutation implements MutationInterface
{

    private $em;
    private $checker;
    private $validator;
    private $fictionCategoryRepository;
    private $fictionRepository;

    public function __construct(
        ValidatorInterface $validator,
        FictionRepository $fictionRepository,
        FictionCategoryRepository $fictionCategoryRepository,
        EntityManagerInterface $em,
        AuthorizationCheckerInterface $checker)
    {
        $this->em = $em;
        $this->checker = $checker;
        $this->validator = $validator;
        $this->fictionCategoryRepository = $fictionCategoryRepository;
        $this->fictionRepository = $fictionRepository;
    }

    public function __invoke(Argument $args, User $user)
    {
        [$title, $body, $fictionId] = [
            $args->offsetGet('title'),
            $args->offsetGet('body'),
            $args->offsetGet('fictionId'),
        ];

        $fiction = $this->fictionRepository->find($fictionId);

        if (!$fiction) {
            throw AppGraphQLException::fromString('Fiction not found');
        }

        $chapter = new FictionChapter();

//        if (!$this->checker->isGranted([FictionVoter::ADD], $fiction)) {
//            throw new UserError('Not allowed!');
//        }

        $chapter
            ->setTitle($title)
            ->addAuthor($user)
            ->setPosition($fiction->getChapters()->count() + 1)
            ->setBody($body);
        $errors = $this->validator->validate($chapter);

        if ($errors->count() > 0) {
            throw AppGraphQLException::fromValidatorErrors($errors);
        }

        $fiction->addChapter($chapter);

        $this->em->flush();

        return compact('fiction');

    }

}