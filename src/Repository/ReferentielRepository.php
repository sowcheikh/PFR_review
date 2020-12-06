<?php

namespace App\Repository;

use App\Entity\Referentiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Referentiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Referentiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Referentiel[]    findAll()
 * @method Referentiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferentielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Referentiel::class);
    }

    // /**
    //  * @return Referentiel[] Returns an array of Referentiel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Referentiel
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findGroupCompetence($value1, $value2)
    {
        return $this->createQueryBuilder('r')
            ->select('r, gp')
            ->join('r.groupeCompetence','gp')
            ->andWhere('gp.id = :value2')
            ->andWhere('r.id = :value1')
            ->setParameter('value2', $value2)
            ->setParameter('value1', $value1)
            ->getQuery()
            ->getResult()
            ;
    }
}
