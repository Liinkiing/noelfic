<?php

namespace App\GraphQL\Resolver\Query;

use App\Repository\FictionRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionsResolver implements ResolverInterface
{
    private $repository;

    public function __construct(FictionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Argument $args): Connection
    {
        $orderBy = $args->offsetGet('orderBy');
        $fictions = $this->repository->findBy(
            [],
            [$orderBy['field'] => $orderBy['direction']]
        );
        $connection = ConnectionBuilder::connectionFromArray($fictions, $args);
        $connection->totalCount = \count($fictions);

        return $connection;
    }
}