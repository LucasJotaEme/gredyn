<?php

namespace App\Repository;

use App\Entity\ClientAndLender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientAndLender|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientAndLender|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientAndLender[]    findAll()
 * @method ClientAndLender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientAndLenderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientAndLender::class);
    }

    // /**
    //  * @return ClientAndLender[] Returns an array of ClientAndLender objects
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
    public function findOneBySomeField($value): ?ClientAndLender
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
