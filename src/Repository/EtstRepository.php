<?php

namespace App\Repository;

use App\Entity\Etst;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etst|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etst|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etst[]    findAll()
 * @method Etst[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtstRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etst::class);
    }

    // /**
    //  * @return Etst[] Returns an array of Etst objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Etst
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
