<?php


namespace App\GraphQL\Resolver\Fiction;


use App\Entity\Fiction;
use App\Repository\FictionCommentRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionRootCommentsResolver implements ResolverInterface
{

    private $repository;

    public function __construct(FictionCommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Fiction $fiction, Argument $args): Connection
    {
        $orderBy = $args->offsetGet('orderBy');
        $comments = $this->repository->findRootCommentsByFictionOrdered($fiction, $orderBy['field'], $orderBy['direction']);
        $connection = ConnectionBuilder::connectionFromArray($comments, $args);
        $connection->totalCount = \count($comments);

        return $connection;
    }
}