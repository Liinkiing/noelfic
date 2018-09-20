<?php


namespace App\GraphQL\Mutation\Fiction;


use App\Entity\Fiction;
use App\Entity\User;
use App\GraphQL\Exception\AppGraphQLException;
use App\Repository\FictionCategoryRepository;
use App\Security\Voter\FictionVoter;
use Doctrine\ORM\EntityManagerInterface;
use GraphQL\Error\UserError;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddFictionMutation implements MutationInterface
{

    private $em;
    private $checker;
    private $validator;
    private $fictionCategoryRepository;

    public function __construct(
        ValidatorInterface $validator,
        FictionCategoryRepository $fictionCategoryRepository,
        EntityManagerInterface $em,
        AuthorizationCheckerInterface $checker)
    {
        $this->em = $em;
        $this->checker = $checker;
        $this->validator = $validator;
        $this->fictionCategoryRepository = $fictionCategoryRepository;
    }

    public function __invoke(Argument $args, User $user)
    {
        [$title, $categoriesId] = [
            $args->offsetGet('title'),
            $args->offsetGet('categoriesId')
        ];

        $fiction = new Fiction();

        if (!$this->checker->isGranted([FictionVoter::ADD], $fiction)) {
            throw new UserError('Not allowed!');
        }

        $categories = $this->fictionCategoryRepository->findByIds($categoriesId);

        $fiction
            ->setTitle($title)
            ->replaceCategories($categories);

        $errors = $this->validator->validate($fiction);

        if ($errors->count() > 0) {
            throw AppGraphQLException::fromValidatorErrors($errors);
        }

        $this->em->flush();

        return compact('fiction');

    }

}