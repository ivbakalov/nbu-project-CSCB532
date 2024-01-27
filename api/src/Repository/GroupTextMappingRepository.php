<?php

namespace App\Repository;

use App\Entity\GroupTextMapping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupTextMapping>
 *
 * @method GroupTextMapping|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupTextMapping|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupTextMapping[]    findAll()
 * @method GroupTextMapping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupTextMappingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupTextMapping::class);
    }

//    /**
//     * @return GroupTextMapping[] Returns an array of GroupTextMapping objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GroupTextMapping
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
