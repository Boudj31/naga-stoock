<?php

namespace App\Repository;

use App\Entity\Society;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Society|null find($id, $lockMode = null, $lockVersion = null)
 * @method Society|null findOneBy(array $criteria, array $orderBy = null)
 * @method Society[]    findAll()
 * @method Society[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocietyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Society::class);
    }

    public function findAllPagination() : Query
    {
        return $this->createQueryBuilder('s')
                ->orderBy('s.id', 'DESC')
                ->getQuery();
    }

    public function findSociety(string $mot)
    {
        return ($queryBuilder =  $this->createQueryBuilder('c'))
        ->where($queryBuilder->expr()->like('c.name', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.representativeName', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.representativeMail', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.representativePhone', ':mot'))
        ->setParameter('mot', '%'.$mot.'%')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Society[] Returns an array of Society objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Society
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
