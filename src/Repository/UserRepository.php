<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use function iter\rewindable\keys;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneWithRole(UserRole $role): ?User
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->leftJoin('u.roles', 'roles')
            ->andWhere(
                $qb->expr()->in(
                    'roles', ':roles'
                )
            )
            ->setParameter('roles', [$role])
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countRegistrationPerDaysOfWeek(): array
    {
        $qb = $this->createQueryBuilder('u');

        $result = $qb
            ->select('WEEKDAY(u.createdAt) as dayOfWeek, DAYNAME(u.createdAt) AS dayName ,COUNT(u) as userCount')
            ->andWhere(
                $qb
                    ->expr()->between(
                        'DAY(u.createdAt)',
                        ':firstDayOfWeek',
                        ':lastDayOfWeek'
                    )
            )
            ->setParameter(':firstDayOfWeek', (new \DateTime('this week monday'))->format('d'))
            ->setParameter(':lastDayOfWeek', (new \DateTime('this week sunday'))->format('d'))
            ->groupBy('dayOfWeek', 'dayName')
            ->orderBy('dayOfWeek')
            ->getQuery()
            ->getArrayResult();

        return $result;
    }
}
