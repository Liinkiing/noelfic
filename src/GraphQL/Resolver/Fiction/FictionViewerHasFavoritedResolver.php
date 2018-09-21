<?php

namespace App\GraphQL\Resolver\Fiction;

use App\Entity\Fiction;
use App\Entity\User;
use App\Repository\FictionUserFavoriteRepository;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class FictionViewerHasFavoritedResolver implements ResolverInterface
{

    private $repository;

    public function __construct(FictionUserFavoriteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Fiction $fiction, User $viewer): bool
    {
        return $this->repository->findOneBy(['user' => $viewer, 'fiction' => $fiction]) !== null;
    }
}
