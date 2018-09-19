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

    /**
     * @return array|Fiction[]
     */
    public function getLastBestFictions(int $max = 5): array
    {
        $qb = $this->createQueryBuilder('f');

        $avg = $qb->expr()->avg('ratings.rating');
        return $qb
            ->leftJoin('f.ratings', 'ratings')
            ->select(
                'f.title',
                'f.createdAt',
                'f.updatedAt',
                'f.id',
                'f.slug',
                "$avg AS average"
            )
            ->orderBy(
                'average',
                'DESC'
            )
            ->andHaving(
                $qb->expr()->isNotNull('average')
            )
            ->addGroupBy('f')
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }

    public function searchLatest(array $parameters, int $page = 1, string $order = 'DESC'): Pagerfanta
    {
        [$q, $c] = [
            $parameters['q'] ?? null,
            $parameters['c'] ?? null
        ];

        $qb = $this->createQueryBuilder('f')
            ->select('f', 'fc', 'c', 'ca')
            ->leftJoin('f.chapters', 'c')
            ->leftJoin('c.authors', 'ca')
            ->leftJoin('f.categories', 'fc');

        if ($q) {
            $qb
                ->andWhere(
                    $qb->expr()->like('f.title', ':query')
                )
                ->setParameter('query', "%$q%");
        }

        if ($c) {
            $qb
                ->andWhere(
                    $qb->expr()->in('fc.title', $c)
                );
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
