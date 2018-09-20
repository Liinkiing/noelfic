<?php


namespace App\GraphQL\Mutation\Fiction;


use App\Entity\User;
use App\GraphQL\Exception\AppGraphQLException;
use App\Repository\FictionCategoryRepository;
use App\Repository\FictionChapterRepository;
use App\Repository\FictionRepository;
use App\Security\Voter\FictionVoter;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EditFictionMutation implements MutationInterface
{

    private $fictionRepository;
    private $em;
    private $checker;
    private $validator;
    private $fictionCategoryRepository;
    private $fictionChapterRepository;

    public function __construct(
        ValidatorInterface $validator,
        FictionRepository $fictionRepository,
        FictionChapterRepository $fictionChapterRepository,
        FictionCategoryRepository $fictionCategoryRepository,
        EntityManagerInterface $em,
        AuthorizationCheckerInterface $checker)
    {
        $this->fictionRepository = $fictionRepository;
        $this->em = $em;
        $this->checker = $checker;
        $this->validator = $validator;
        $this->fictionCategoryRepository = $fictionCategoryRepository;
        $this->fictionChapterRepository = $fictionChapterRepository;
    }

    public function __invoke(Argument $args, User $user)
    {
        [$fictionId, $chaptersPosition, $title, $categoriesId] = [
            $args->offsetGet('fictionId'),
            $args->offsetGet('chaptersPosition'),
            $args->offsetGet('title'),
            $args->offsetGet('categoriesId')
        ];


        $fiction = $this->fictionRepository->find($fictionId);

        if(!$fiction) {
            throw new UserError('Fiction not found');
        }

        if(!$this->checker->isGranted([FictionVoter::EDIT], $fiction)) {
            throw new UserError('Not allowed!');
        }

        $categories = $this->fictionCategoryRepository->findByIds($categoriesId);

        $fiction
            ->setTitle($title)
            ->replaceCategories($categories);

        $errors = $this->validator->validate($fiction);

        if($errors->count() > 0) {
            throw AppGraphQLException::fromValidatorErrors($errors);
        }

        foreach ($chaptersPosition as $chapterPosition) {
            if($chapter = $this->fictionChapterRepository->find($chapterPosition['fictionChapterId'])) {
                $chapter->setPosition($chapterPosition['position']);
            }
        }

        $this->em->flush();

        return compact('fiction');

    }

}