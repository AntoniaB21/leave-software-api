<?php

namespace App\Repository;

use App\Entity\ValidationTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ValidationTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValidationTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValidationTemplate[]    findAll()
 * @method ValidationTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValidationTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValidationTemplate::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ValidationTemplate $entity, bool $flush = true): void
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
    public function remove(ValidationTemplate $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ValidationTemplate[] Returns an array of ValidationTemplate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findOneByTeam($team): ?ValidationTemplate
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.team = :team')
            ->setParameter('team', $team)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
