<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Profil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

       /**
        * @return Post[] Returns an array of Post objects
        */
       public function getPostFromFollowed(Profil $profil): array
       {
           return $this->createQueryBuilder('p')
           ->innerJoin('p.profil', 'a')
           ->innerJoin('a.followers', 'f')
           ->where('f.id = :userId')
           ->setParameter('userId', $profil->getId())
           ->orderBy('p.createdAt', 'DESC')
           ->getQuery()
           ->getResult();
           ;
       }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
