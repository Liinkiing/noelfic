<?php

namespace App\Repository;

use App\Entity\FictionCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FictionCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FictionCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FictionCategory[]    findAll()
 * @method FictionCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FictionCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FictionCategory::class);
    }
}
