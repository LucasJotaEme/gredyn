<?php

namespace App\Repository;

use App\Entity\LenderOwner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LenderOwner|null find($id, $lockMode = null, $lockVersion = null)
 * @method LenderOwner|null findOneBy(array $criteria, array $orderBy = null)
 * @method LenderOwner[]    findAll()
 * @method LenderOwner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LenderOwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LenderOwner::class);
    }

    // /**
    //  * @return LenderOwner[] Returns an array of LenderOwner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LenderOwner
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
