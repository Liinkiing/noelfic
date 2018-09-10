<?php

namespace App\Repository;

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
}
