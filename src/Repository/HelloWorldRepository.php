<?php

namespace App\Repository;

use App\Entity\HelloWorld;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HelloWorld|null find($id, $lockMode = null, $lockVersion = null)
 * @method HelloWorld|null findOneBy(array $criteria, array $orderBy = null)
 * @method HelloWorld[]    findAll()
 * @method HelloWorld[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HelloWorldRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HelloWorld::class);
    }

    // /**
    //  * @return HelloWorld[] Returns an array of HelloWorld objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HelloWorld
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
