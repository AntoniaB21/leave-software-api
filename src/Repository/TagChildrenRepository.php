<?php

namespace App\Repository;

use App\Entity\TagChildren;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TagChildren|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagChildren|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagChildren[]    findAll()
 * @method TagChildren[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagChildrenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagChildren::class);
    }

    // /**
    //  * @return TagChildren[] Returns an array of TagChildren objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TagChildren
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
