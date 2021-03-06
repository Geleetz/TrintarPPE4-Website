<?php

namespace App\Repository;

use App\Entity\Licence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Licence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licence[]    findAll()
 * @method Licence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licence::class);
    }

    public function day(\Datetime $date)
    {
        $from = (Date($date->format("Y-m-d")." 00:00:00"));
        $to   = (Date($date->format("Y-m-d")." 23:59:59"));

        return $this->findVisibleQuery()
            ->andWhere('l.createdAt BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();
    }

    public function week(\Datetime $date)
    {
        $from = (Date("Y-m-d", strtotime("-1 week"))." 00:00:00" );
        $to   = (Date($date->format("Y-m-d")." 23:59:59"));

        return $this->findVisibleQuery()
            ->andWhere('l.createdAt BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();
    }

    public function month(\Datetime $date)
    {
        $from = (Date("Y-m-d", strtotime("-1 month"))." 00:00:00" );
        $to   = (Date($date->format("Y-m-d")." 23:59:59"));

        return $this->findVisibleQuery()
            ->andWhere('l.createdAt BETWEEN :from AND :to')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('l');
    }

}
