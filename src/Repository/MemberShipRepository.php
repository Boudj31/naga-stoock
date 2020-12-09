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

    public function selectMemberCount() {
                
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }
 // FIN TOTAL

 
// ADHESION GEM 3 MOIS
 
   public function selectTotalMembersGem() {
         
       $query = $this->createQueryBuilder('m')
            ->select('count(m.id)')
            ->where('m.type = :type')
            ->setParameter('type', 'Adhésion GEM 3 mois')
            ->getQuery();
    
       return $query->getOneOrNullResult();
    
    }

    public function selectTotalMembershipPriceGem() {
        
        $query = $this->createQueryBuilder('m')
                ->select('sum(m.amount)')
                ->where('m.type = :type')
                ->setParameter('type', 'Adhésion GEM 3 mois')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }

    public function selectAvgMembershipPriceGem() {
        
        $query = $this->createQueryBuilder('m')
                ->select('avg(m.amount)')
                ->where('m.type = :type')
                ->setParameter('type', 'Adhésion GEM 3 mois')
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }
   // FIN ADHESION 3

   // ADHESION RSA
 
   public function selectTotalMembersRSA() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Adhésion RSA')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceRSA() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion RSA')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPriceRSA() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion RSA')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION RSA

   // ADHESION SMIC
 
   public function selectTotalMembersSMIC() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Adhésion SMIC')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceSMIC() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion SMIC')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPriceSMIC() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion SMIC')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION SMIC

   // ADHESION BENEVOLE
 
   public function selectTotalMembersBenevole() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Adhésion bénévole')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceBenevole() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion bénévole')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPriceBenevole() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion bénévole')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION BENEVOLE

   // ADHESION LINUX
 
   public function selectTotalMembersLinux() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Adhésion installation Linux')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceLinux() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion installation Linux')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPriceLinux() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion installation Linux')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION Linux

   // ADHESION SUP SMIC
 
   public function selectTotalMembersSup() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Adhésion sup SMIC')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceSup() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion sup SMIC')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPricesSup() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Adhésion sup SMIC')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION SUP SMIC

   // ADHESION DON
 
   public function selectTotalMembersGift() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Don')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceGift() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Don')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPriceGift() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Don')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION DON

   // ADHESION VENTE
 
   public function selectTotalMembersSales() {
         
    $query = $this->createQueryBuilder('m')
         ->select('count(m.id)')
         ->where('m.type = :type')
         ->setParameter('type', 'Vente')
         ->getQuery();
 
    return $query->getOneOrNullResult();
 
 }

 public function selectTotalMembershipPriceSales() {
     
     $query = $this->createQueryBuilder('m')
             ->select('sum(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Vente')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }

 public function selectAvgMembershipPriceSales() {
     
     $query = $this->createQueryBuilder('m')
             ->select('avg(m.amount)')
             ->where('m.type = :type')
             ->setParameter('type', 'Vente')
             ->getQuery();
     
     return $query->getOneOrNullResult();
     
 }
// FIN ADHESION VENTE

    public function selectSumOfMembersWithComputer() {
        
        $slug = '';
        
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->andWhere('m.computer != :slug')
                ->setParameter('slug', $slug)
                ->getQuery();
        
        return $query->getOneOrNullResult();
        
    }


    public function selectSumOfMembersWithoutComputer() {
        
        $query = $this->createQueryBuilder('m')
                ->select('count(m.id)')
                ->andWhere('m.computer IS NULL')
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
