<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Utils\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function countCommentPerDaysOfWeek(): array
    {
        $qb = $this->createQueryBuilder('c');

        $result = $qb
            ->select('WEEKDAY(c.createdAt) as dayOfWeek, DAYNAME(c.createdAt) AS dayName ,COUNT(c) as commentCount')
            ->andWhere(
                $qb
                    ->expr()->between(
                        'DAY(c.createdAt)',
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

        return Date::getOrderedChartData($result, 'commentCount');
    }
}
