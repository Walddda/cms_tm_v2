<?php

namespace App\Repository;

use App\Entity\TimeMachineEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeMachineEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeMachineEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeMachineEntry[]    findAll()
 * @method TimeMachineEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeMachineEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeMachineEntry::class);
    }

    // /**
    //  * @return TimeMachineEntry[] Returns an array of TimeMachineEntry objects
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
    public function findOneBySomeField($value): ?TimeMachineEntry
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
