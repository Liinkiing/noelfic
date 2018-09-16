<?php


namespace App\GraphQL\Resolver\Fiction\Chapter;


use App\Entity\FictionChapter;
use App\Repository\FictionChapterCommentRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class FictionChapterCommentsResolver implements ResolverInterface
{
    private $repository;

    public function __construct(FictionChapterCommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FictionChapter $chapter, Argument $args): Connection
    {
        $orderBy = $args->offsetGet('orderBy');
        $chapters = $this->repository->findBy(
            ['chapter' => $chapter],
            [$orderBy['field'] => $orderBy['direction']]
        );
        $connection = ConnectionBuilder::connectionFromArray($chapters, $args);
        $connection->totalCount = \count($chapters);

        return $connection;
    }
}