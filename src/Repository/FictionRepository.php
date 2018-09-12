<?php

namespace App\Repository;

use App\Entity\Fiction;
use App\Traits\PaginatedRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fiction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiction[]    findAll()
 * @method Fiction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionRepository extends ServiceEntityRepository
{
    use PaginatedRepository;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fiction::class);
    }

    public function searchLatest(array $parameters, int $page = 1, $order = 'DESC'): Pagerfanta
    {
        $q = $parameters['q'] ?? null;

        $qb = $this->createQueryBuilder('f');

        if ($q) {
            $qb
                ->andWhere(
                    $qb->expr()->like('f.title', ':query')
                )
                ->setParameter('query', "%$q%");
        }

        $qb->addOrderBy('f.createdAt', $order);

        return $this->createPaginator(
            $qb->getQuery(),
            $page
        );
    }

    public function getAverageRating(Fiction $fiction, float $precision = 1): float
    {
        $qb = $this->createQueryBuilder('f');

        return round(
            $qb
                ->leftJoin('f.ratings', 'ratings')
                ->select(
                    $qb->expr()->avg('ratings.rating')
                )
                ->andWhere(
                    $qb->expr()->eq('f', ':fiction')
                )
                ->setParameter('fiction', $fiction)
                ->groupBy('f')
                ->getQuery()
                ->getSingleScalarResult(),
            $precision);
    }

}
