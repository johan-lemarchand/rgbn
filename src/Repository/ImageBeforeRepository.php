<?php

namespace App\Repository;

use App\Entity\ImageBefore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageBefore|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageBefore|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageBefore[]    findAll()
 * @method ImageBefore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageBeforeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageBefore::class);
    }

    // /**
    //  * @return ImageBefore[] Returns an array of ImageBefore objects
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
    public function findOneBySomeField($value): ?ImageBefore
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
