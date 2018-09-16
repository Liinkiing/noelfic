<?php


namespace App\GraphQL\Resolver\Fiction\Chapter;


use App\Entity\FictionChapter;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionChapterRootCommentsResolver implements ResolverInterface
{

    public function __invoke(FictionChapter $chapter, Argument $args): Connection
    {
        $chapters = $chapter->getRootComments();
        $connection = ConnectionBuilder::connectionFromArray($chapters, $args);
        $connection->totalCount = \count($chapters);

        return $connection;
    }
}