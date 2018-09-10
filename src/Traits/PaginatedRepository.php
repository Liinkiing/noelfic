<?php


namespace App\Traits;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

trait PaginatedRepository
{

    public function findLatest(int $page = 1, string $order = 'DESC'): Pagerfanta
    {
        $alias = $this->getClassMetadata()->reflClass->getShortName();
        $qb = $this->createQueryBuilder($alias);

        if ($this->getClassMetadata()->reflClass->hasProperty('createdAt')) {
            $qb->addOrderBy("$alias.createdAt", $order);
        }

        return $this->createPaginator(
            $qb->getQuery(),
            $page
        );
    }

    protected function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $maxPerPage = $this->getClassMetadata()->reflClass->hasConstant('NUM_ITEMS') ?
            $this->getClassMetadata()->reflClass->getConstant('NUM_ITEMS') :
            10;
        $paginator->setMaxPerPage($maxPerPage);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}