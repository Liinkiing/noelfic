<?php

namespace App\Repository;

use App\Entity\UserRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserRole[]    findAll()
 * @method UserRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRoleRepository extends ServiceEntityRepository
{
    public const DEFAULT_ROLE = 'ROLE_USER';

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserRole::class);
    }

    public function getDefaultRole(): UserRole
    {
        return $this->createQueryBuilder('ur')
            ->where('ur.role = :role')
            ->setParameter('role', self::DEFAULT_ROLE)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
