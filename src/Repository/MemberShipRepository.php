<?php

namespace App\Repository;

use App\Entity\MemberShip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberShip|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberShip|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberShip[]    findAll()
 * @method MemberShip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberShipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberShip::class);
    }

    public function findAllPagination() : Query
    {
        return $this->createQueryBuilder('m')
                ->orderBy('m.id', 'DESC')
                ->getQuery();
    }
    public function selectSalesByMonth($year, $month)
    {
        $query = $this->createQueryBuilder('m')
            ->select('sum(m.amount)')
            ->where('m.beginAt >= :fromDate AND m.beginAt <= :toDate')
            ->andWhere('m.type = :type')
            ->setParameter('fromDate', $year.'-'.$month.'-01 00:00:00')
            ->setParameter('toDate', $year.'-'.$month.'-31 00:00:00')
            ->setParameter('type', 'sale')
            ->getQuery();

        return $query->getSingleScalarResult();
    }


    // /**
    //  * @return MemberShip[] Returns an array of MemberShip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemberShip
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
