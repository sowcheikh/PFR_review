<?php

namespace App\Repository;

use App\Entity\ProfileSortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfileSortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileSortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileSortie[]    findAll()
 * @method ProfileSortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileSortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileSortie::class);
    }

    // /**
    //  * @return ProfileSortie[] Returns an array of ProfileSortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfileSortie
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
