<?php

namespace App\Repository;

use App\Entity\MessageRecipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageRecipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageRecipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageRecipe[]    findAll()
 * @method MessageRecipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageRecipe::class);
    }

    // /**
    //  * @return MessageRecipe[] Returns an array of MessageRecipe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageRecipe
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
