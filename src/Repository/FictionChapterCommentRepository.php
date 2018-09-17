<?php

namespace App\Repository;

use App\Entity\Fiction;
use App\Entity\FictionChapter;
use App\Entity\FictionChapterComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FictionChapterComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method FictionChapterComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method FictionChapterComment[]    findAll()
 * @method FictionChapterComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionChapterCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FictionChapterComment::class);
    }

    /**
     * @return array|FictionChapterComment[]
     */
    public function findRootCommentsByChapterOrdered(FictionChapter $chapter, string $field = 'createdAt', string $direction = 'DESC'): array
    {
        $qb = $this->createQueryBuilder('fcc');

        return $qb
            ->andWhere(
                $qb->expr()->isNull('fcc.parent')
            )
            ->andWhere(
                $qb->expr()->eq('fcc.chapter', ':chapter')
            )
            ->setParameter('chapter', $chapter)
            ->addOrderBy("fcc.$field", $direction)
            ->getQuery()
            ->getResult();

    }
}
