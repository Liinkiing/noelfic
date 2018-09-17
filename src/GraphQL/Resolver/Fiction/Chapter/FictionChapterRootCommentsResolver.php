<?php


namespace App\GraphQL\Resolver\Fiction\Chapter;


use App\Entity\FictionChapter;
use App\Repository\FictionChapterCommentRepository;
use App\Repository\FictionChapterRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionChapterRootCommentsResolver implements ResolverInterface
{

    private $repository;

    public function __construct(FictionChapterCommentRepository $repository)    {
        $this->repository = $repository;
    }

    public function __invoke(FictionChapter $chapter, Argument $args): Connection
    {
        $orderBy = $args->offsetGet('orderBy');
        $comments = $this->repository->findRootCommentsByChapterOrdered($chapter, $orderBy['field'], $orderBy['direction']);
        $connection = ConnectionBuilder::connectionFromArray($comments, $args);
        $connection->totalCount = \count($comments);

        return $connection;
    }
}