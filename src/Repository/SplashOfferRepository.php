<?php

namespace App\Repository;

use App\Entity\SplashOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SplashOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SplashOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SplashOffer[]    findAll()
 * @method SplashOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SplashOfferRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SplashOffer::class);
    }

//    /**
//     * @return SplashOffer[] Returns an array of SplashOffer objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SplashOffer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
