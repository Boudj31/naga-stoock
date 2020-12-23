<?php

namespace App\Repository;

use App\Entity\Cash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cash|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cash|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cash[]    findAll()
 * @method Cash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cash::class);
    }
    public function selectLastTotal() {
        
        $query = $this->createQueryBuilder('c')
                ->addSelect('c.total')
                ->orderBy('c.id', 'DESC')
                ->setMaxResults(1)
                ->getQuery();

        return $query->getOneOrNullResult();
        
    }
    
    public function findAllPagination() : Query
    {
        return $this->createQueryBuilder('c')
                ->orderBy('c.id', 'DESC')
                ->getQuery();
    }

    public function SelectAllTotal() {
        $query = $this->createQueryBuilder('c')       
                ->addSelect('c.total')
                ->getQuery()
                ;

                return $query->getOneOrNullResult();
    }

    // /**
    //  * @return Cash[] Returns an array of Cash objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cash
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
