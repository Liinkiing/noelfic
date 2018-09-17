<?php


namespace App\GraphQL\Resolver\Fiction;


use App\Entity\Fiction;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionRootCommentsResolver implements ResolverInterface
{

    public function __invoke(Fiction $fiction, Argument $args): Connection
    {
        $chapters = $fiction->getRootComments();
        $connection = ConnectionBuilder::connectionFromArray($chapters, $args);
        $connection->totalCount = \count($chapters);

        return $connection;
    }
}