<?php

namespace App\Repository;

use App\Entity\Computer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Computer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Computer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Computer[]    findAll()
 * @method Computer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComputerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Computer::class);
    }

    public function findAllPagination() : Query
    {
        return $this->createQueryBuilder('c')
                ->orderBy('c.id', 'DESC')
                ->getQuery();
    }
    public function selectComputersCount() {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->getQuery();
                
        return $query->getOneOrNullResult();
        
    }
    public function selectGivenComputers() {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.status = :status')
                ->setParameter('status', 'Donné')
                ->getQuery();
        return $query->getOneOrNullResult();
        
    }

    public function selectComputersInStock() {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.status = :status')
                ->setParameter('status','En stock')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }
    public function selectComputersAsso() {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.status = :status')
                ->setParameter('status','Donné asso')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }
    public function selectComputersBreak() {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.status = :status')
                ->setParameter('status','Démonté')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    public function findLast()
    {
        return $this->createQueryBuilder('computer')
                ->orderBy('computer.id', 'DESC')
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
    }

    public function selectComputerByMonth($year, $month) {
         
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.receivedAt >= :fromDate AND c.receivedAt <= :toDate')
                ->andWhere('c.type = :type')
                ->setParameter('fromDate', $year.'-'.$month.'-01 00:00:00')
                ->setParameter('toDate', $year.'-'.$month.'-31 00:00:00')
                ->setParameter('type', 'Donné')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    // /**
    //  * @return Computer[] Returns an array of Computer objects
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
    public function findOneBySomeField($value): ?Computer
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
