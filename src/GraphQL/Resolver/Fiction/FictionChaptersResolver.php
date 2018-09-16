<?php


namespace App\GraphQL\Resolver\Fiction;


use App\Entity\Fiction;
use App\Repository\FictionChapterRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionChaptersResolver implements ResolverInterface
{
    private $repository;

    public function __construct(FictionChapterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Fiction $fiction, Argument $args): Connection
    {
        $orderBy = $args->offsetGet('orderBy');
        $chapters = $this->repository->findBy(
            ['fiction' => $fiction],
            [$orderBy['field'] => $orderBy['direction']]
        );
        $connection = ConnectionBuilder::connectionFromArray($chapters, $args);
        $connection->totalCount = \count($chapters);

        return $connection;
    }
}