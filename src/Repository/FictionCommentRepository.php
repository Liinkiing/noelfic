<?php

namespace App\Repository;

use App\Entity\FictionComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FictionComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method FictionComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method FictionComment[]    findAll()
 * @method FictionComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FictionComment::class);
    }
}
