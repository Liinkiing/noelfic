<?php

namespace App\GraphQL\Resolver\Query;

use App\Repository\FictionCategoryRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class FictionCategoriesResolver implements ResolverInterface
{
    private $repository;

    public function __construct(FictionCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Argument $args): array
    {
        return $this->repository->findAll();
    }
}