<?php

namespace App\Repository;

use App\Entity\Tranfert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tranfert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tranfert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tranfert[]    findAll()
 * @method Tranfert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranfertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tranfert::class);
    }

    public function selectLastTotal() {
        
        $query = $this->createQueryBuilder('t')
                ->addSelect('t.total')
                ->orderBy('t.id', 'DESC')
                ->setMaxResults(1)
                ->getQuery();

        return $query->getOneOrNullResult();
        
    }
    public function findAllPagination() : Query
    {
        return $this->createQueryBuilder('t')
                ->orderBy('t.id', 'DESC')
                ->getQuery();
    }

    // /**
    //  * @return Tranfert[] Returns an array of Tranfert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tranfert
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
