<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;

use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findAllPagination() : Query
    {
        return $this->createQueryBuilder('c')
                ->orderBy('c.id', 'DESC')
                ->getQuery();
    }

    public function findContact(string $mot)
    {
        return ($queryBuilder =  $this->createQueryBuilder('c'))
        ->where($queryBuilder->expr()->like('c.lastname', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.firstname', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.mail', ':mot'))
        ->orWhere($queryBuilder->expr()->like('c.phone', ':mot'))
        ->setParameter('mot', '%'.$mot.'%')
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
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
    public function findOneBySomeField($value): ?Contact
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
