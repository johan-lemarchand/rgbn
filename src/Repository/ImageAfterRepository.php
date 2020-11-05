<?php

namespace App\Repository;

use App\Entity\ImageAfter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageAfter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageAfter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageAfter[]    findAll()
 * @method ImageAfter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageAfterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageAfter::class);
    }

    // /**
    //  * @return ImageAfter[] Returns an array of ImageAfter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageAfter
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
