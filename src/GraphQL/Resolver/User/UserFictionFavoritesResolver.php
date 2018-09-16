<?php


namespace App\GraphQL\Resolver\User;


use App\Entity\User;
use App\Repository\FictionUserFavoriteRepository;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Relay\Connection\Output\Connection;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;

class UserFictionFavoritesResolver implements ResolverInterface
{
    private $repository;

    public function __construct(FictionUserFavoriteRepository $repository)
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