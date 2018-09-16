<?php


namespace App\GraphQL\Resolver\User;


use App\Entity\User;
use App\Repository\FictionUserRatingRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class UserFictionRatingsResolver implements ResolverInterface
{
    private $repository;

    public function __construct(FictionUserRatingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(User $user, Argument $args): Connection
    {
        $chapters = $this->repository->findBy([
            'user' => $user
        ]);
        $connection = ConnectionBuilder::connectionFromArray($chapters, $args);
        $connection->totalCount = \count($chapters);

        return $connection;
    }
}