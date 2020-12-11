<?php

namespace App\Repository;

use App\Entity\Computer;
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

    public function findMember(string $mot)
    {
        return ($queryBuilder =  $this->createQueryBuilder('m'))
        ->where($queryBuilder->expr()->like('m.type', ':mot'))
        ->andWhere($queryBuilder->expr()->like('m.mode', ':mot'))
        ->setParameter('mode', '%'.$mot.'%')
        ->setParameter('type', '%'.$mot.'%')
        ->getQuery()
        ->getResult();
    }

    // TOTAL
    public function selectAmountSum() {
        
        $query = $this->createQueryBuilder('m')
                ->select('Sum(m.amount)')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    public function selectResidualSum() {
        
        $query = $this->createQueryBuilder('m')
                ->select('Sum(m.residual)')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    public function selectAvgMembershipPrice() {
        
        $query = $this->createQueryBuilder('m')
                ->select('avg(m.amount)')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    public function selectMemberTotalCount() {
                
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    public function selectMemberCount() {
                
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->where('m.type != :type')
                ->setParameter('type', MemberShip::SALES)
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }
 // FIN TOTAL

 // ADHESION GEM 3 MOIS
 
 public function selectTotalMembers($value) {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', $value)
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPrice($value) {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', $value)
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembership($value) {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', $value)
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

    public function selectSumOfMembersWithComputer() {
        
        $slug = '';
        
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->where('m.type != :type')
                ->andWhere('m.computer != :slug')
                ->setParameter('slug', $slug)
                ->setParameter('type', MemberShip::SALES)
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }


    public function selectSumOfMembersWithoutComputer() {
        
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->where('m.type != :type')
                ->andWhere('m.computer IS NULL')
                ->setParameter('type', MemberShip::SALES)
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }


  // SELECT BY MONTH

   public function selectMembershipsByMonth($year, $month, $value) {
         
    $query = $this->createQueryBuilder('m')
            ->select('sum(m.amount)')
            ->where('m.beginAt >= :fromDate AND m.beginAt <= :toDate')
            ->andWhere('m.type = :type')
            ->setParameter('fromDate', $year.'-'.$month.'-01 00:00:00')
            ->setParameter('toDate', $year.'-'.$month.'-31 00:00:00')
            ->setParameter('type', $value)
            ->getQuery();
    
    return $query->getOneOrNullResult();
    
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
