<?php

namespace App\Repository;

use App\Entity\FrequentQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FrequentQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FrequentQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FrequentQuestion[]    findAll()
 * @method FrequentQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrequentQuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FrequentQuestion::class);
    }

//    /**
//     * @return FrequentQuestion[] Returns an array of FrequentQuestion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FrequentQuestion
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
