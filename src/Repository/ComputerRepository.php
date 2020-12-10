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
    public function selectComputersCount($type) {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.type = :type')
                ->setParameter('type', $type)
                ->getQuery();
                
        return $query->getOneOrNullResult();
        
    }

    public function findComputer(string $mot)
    {
        return ($queryBuilder =  $this->createQueryBuilder('c'))
        ->where($queryBuilder->expr()->like('c.serial', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.type', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.status', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.comment', ':mot'))
        ->setParameter('mot', '%'.$mot.'%')
        ->getQuery()
        ->getResult();
    }
    
    public function selectComputers($status, $type) {
        
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.status = :status')
                ->andWhere('c.type = :type')
                ->setParameter('status', $status)
                ->setParameter('type', $type )
                ->getQuery();
        return $query->getOneOrNullResult();
        
    }

    public function selectComputerByMonth($year, $month, $value) {
         
        $query = $this->createQueryBuilder('c')
                ->select('count(c.id)')
                ->where('c.receivedAt >= :fromDate AND c.receivedAt <= :toDate')
                ->andWhere('c.type = :type')
                ->setParameter('fromDate', $year.'-'.$month.'-01 00:00:00')
                ->setParameter('toDate', $year.'-'.$month.'-31 00:00:00')
                ->setParameter('type', $value)
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
