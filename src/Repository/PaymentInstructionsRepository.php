<?php

namespace App\Repository;

use App\Entity\PaymentInstructions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PaymentInstructions|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentInstructions|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentInstructions[]    findAll()
 * @method PaymentInstructions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentInstructionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PaymentInstructions::class);
    }

//    /**
//     * @return PaymentInstructions[] Returns an array of PaymentInstructions objects
//     */
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
    public function findOneBySomeField($value): ?PaymentInstructions
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
