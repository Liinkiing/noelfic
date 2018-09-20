<?php

namespace App\GraphQL\Mutation\FictionUserFavorite;

use App\Entity\User;
use App\GraphQL\Exception\AppGraphQLException;
use App\Repository\FictionUserFavoriteRepository;
use App\Security\Voter\FictionUserFavoriteVoter;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DeleteFictionUserFavoriteMutation implements MutationInterface
{

    private $repository;
    private $entityManager;
    private $checker;

    public function __construct(
        FictionUserFavoriteRepository $repository,
        EntityManagerInterface $entityManager,
        AuthorizationCheckerInterface $checker
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->checker = $checker;
    }

    public function __invoke(Argument $args, User $viewer)
    {
        $fictionUserFavorite = $this->repository->findOneBy(['user' => $viewer, 'fiction' => $args->offsetGet('fictionId')]);

        if (!$fictionUserFavorite) {
            throw new \RuntimeException('FictionUserFavorite not found');
        }

        if ($this->checker->isGranted([FictionUserFavoriteVoter::DELETE], $fictionUserFavorite)) {
            $fiction = $fictionUserFavorite->getFiction();
            $this->entityManager->remove($fictionUserFavorite);
            $this->entityManager->flush();

            return compact('fiction');
        }


        throw AppGraphQLException::fromString('errors.fictionUserFavorite.delete_forbidden');
    }
}
