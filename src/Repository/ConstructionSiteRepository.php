<?php

namespace App\Repository;

use App\Entity\ConstructionSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConstructionSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConstructionSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConstructionSite[]    findAll()
 * @method ConstructionSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConstructionSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConstructionSite::class);
    }

}
