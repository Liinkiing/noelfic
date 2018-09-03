<?php

namespace App\Repository;

use App\Entity\FictionUserFavorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FictionUserFavorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method FictionUserFavorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method FictionUserFavorite[]    findAll()
 * @method FictionUserFavorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionUserFavoriteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FictionUserFavorite::class);
    }
}
