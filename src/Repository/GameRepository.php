<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findByTitlePart($title): array
{
  $qb = $this->createQueryBuilder('a')
           ->where('a.Title LIKE :title')
           ->setParameter('title', '%'.$title.'%')
           ->getQuery();

       return $qb->execute();
}

public function findByGenre($target, $category): array
{
$qb = $this->createQueryBuilder('a')
       ->where('a.Target = :target')
       ->andWhere('a.Genre LIKE :category')
       ->setParameters(['target'=> $target, 'category'=> '%'.$category.'%'])
       ->getQuery();

   return $qb->execute();
}

//    /**
//     * @return Game[] Returns an array of Game objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
