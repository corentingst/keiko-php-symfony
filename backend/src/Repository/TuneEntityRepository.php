<?php

namespace App\Repository;

use App\Entity\TuneEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TuneEntity>
 *
 * @method TuneEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TuneEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TuneEntity[]    findAll()
 * @method TuneEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TuneEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TuneEntity::class);
    }

//    /**
//     * @return TuneEntity[] Returns an array of TuneEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TuneEntity
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
