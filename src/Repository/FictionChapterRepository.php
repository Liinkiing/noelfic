<?php

namespace App\Repository;

use App\Entity\FictionChapter;
use App\Entity\Fiction;
use App\Traits\PaginatedRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FictionChapter|null find($id, $lockMode = null, $lockVersion = null)
 * @method FictionChapter|null findOneBy(array $criteria, array $orderBy = null)
 * @method FictionChapter[]    findAll()
 * @method FictionChapter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionChapterRepository extends ServiceEntityRepository
{
    use PaginatedRepository;

    public function findLatestForFiction(Fiction $fiction, int $page = 1, string $order = 'DESC'): Pagerfanta
    {
        $qb = $this->createQueryBuilder('fc');

        $qb
            ->andWhere(
                $qb->expr()->eq('fc.fiction', ':fiction')
            )
            ->setParameter('fiction', $fiction)
            ->addOrderBy('fc.position', $order);

        return $this->createPaginator(
            $qb->getQuery(),
            $page
        );
    }


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FictionChapter::class);
    }


    public function countByFiction(Fiction $fiction): int
    {
        $qb = $this->createQueryBuilder('c');
        return (int)$qb
            ->andWhere('c.fiction = :fiction')
            ->setParameter('fiction', $fiction)
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

    }

    public function findByFictionSlugAndPosition(string $slug, int $position): ?FictionChapter
    {
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->innerJoin('c.fiction', 'fiction')
            ->andWhere($qb->expr()->eq('fiction.slug', ':slug'))
            ->setParameter('slug', $slug)
            ->andWhere($qb->expr()->eq('c.position', $position))
            ->getQuery()
            ->getOneOrNullResult();
    }

}
