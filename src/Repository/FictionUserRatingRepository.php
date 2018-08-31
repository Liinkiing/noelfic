<?php

namespace App\Repository;

use App\Entity\FictionUserRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FictionUserRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method FictionUserRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method FictionUserRating[]    findAll()
 * @method FictionUserRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionUserRatingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FictionUserRating::class);
    }
}
