<?php

namespace App\Repository;

use App\Entity\CheckIn;
use App\Entity\ConstructionSite;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CheckIn|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckIn|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckIn[]    findAll()
 * @method CheckIn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckIn::class);
    }

    public function userAlReadyRegisteredForDay(User $user, ConstructionSite $constructionSite, \DateTime $dateTime = null)
    {
        $date = $dateTime === null ? new \DateTime : $dateTime;

        return $this->createQueryBuilder('c')
            ->leftJoin('c.user','user')
            ->leftJoin('c.constructionSite','constructionSite')
            ->where('user.id = :user_id')
                ->setParameter('user_id', $user->getId())
            ->andWhere('constructionSite.id = :construction_site')
                ->setParameter('construction_site',$constructionSite->getId())
            ->andWhere('c.dateOfCheckIn = :dateOfCheckIn')
                ->setParameter('dateOfCheckIn',$date->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function userDurationBetweenDates(User $user, ConstructionSite $constructionSite, \DateTime $startDate, \DateTime $endDate)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.user','user')
            ->leftJoin('c.constructionSite','constructionSite')
            ->where('user.id = :user_id')
                ->setParameter('user_id', $user->getId())
            ->andWhere('constructionSite.id = :construction_site')
                ->setParameter('construction_site',$constructionSite->getId())
            ->andWhere('c.dateOfCheckIn >= :start_date')
                ->setParameter('start_date', $startDate->format('Y-m-d'))
            ->andWhere('c.dateOfCheckIn <= :end_date')
                ->setParameter('end_date', $endDate->format('Y-m-d'))
            ->select('SUM(c.duration) as duration')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function userCheckedOfConstructionSite(ConstructionSite $constructionSite, array $select)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.constructionSite','constructionSite')
            ->leftJoin('c.user','user')
            ->where('constructionSite.id = :construction_site_id')
                ->setParameter('construction_site_id', $constructionSite->getId())
            ->select($select)
            ->groupBy('c.user')
            ->getQuery()
            ->getResult()
        ;
    }


}
