<?php

namespace App\GraphQL\Mutation\FictionUserFavorite;

use App\Entity\FictionUserFavorite;
use App\Entity\User;
use App\GraphQL\Exception\AppGraphQLException;
use App\Repository\FictionRepository;
use App\Security\Voter\FictionUserFavoriteVoter;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AddFictionUserFavoriteMutation implements MutationInterface
{

    private $repository;
    private $entityManager;
    private $checker;

    public function __construct(
        FictionRepository $repository,
        EntityManagerInterface $entityManager,
        AuthorizationCheckerInterface $checker
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->checker = $checker;
    }

    public function __invoke(Argument $args, User $viewer)
    {
        $fictionId = $args->offsetGet('fictionId');

        if ($fiction = $this->repository->find($fictionId)) {
            $fictionUserFavorite = new FictionUserFavorite($fiction, $viewer);
            if (!$this->checker->isGranted([FictionUserFavoriteVoter::ADD], $fictionUserFavorite)) {
                throw AppGraphQLException::fromString('errors.fictionUserFavorite.add_forbidden');
            }
             $this->entityManager->persist($fictionUserFavorite);
             $this->entityManager->flush();

             return ['fiction' => $fictionUserFavorite->getFiction()];
        }

        throw AppGraphQLException::fromString('fiction not found.');
    }
}
