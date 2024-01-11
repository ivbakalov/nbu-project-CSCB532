<?php

namespace App\Repository;

use App\Entity\TextEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TextEntry>
 *
 * @method TextEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method TextEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method TextEntry[]    findAll()
 * @method TextEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TextEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextEntry::class);
    }

//    /**
//     * @return TextEntry[] Returns an array of TextEntry objects
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

//    public function findOneBySomeField($value): ?TextEntry
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
