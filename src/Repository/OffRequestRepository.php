<?php

namespace App\Repository;

use App\Entity\OffRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffRequest[]    findAll()
 * @method OffRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffRequest::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OffRequest $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(OffRequest $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return OffRequest[] Returns an array of OffRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffRequest
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

        
    /**
     * @return array
     */
    public function getValidationListByManager($userId)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.validator=:userId')
            ->setParameter('userId', $userId)
            ->andWhere('o.status=:pending')
            ->setParameter('pending', 'pending')
            ->getQuery()
            ->execute()
        ;
    }
}
