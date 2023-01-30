<?php

namespace App\Repository;

use App\Entity\Idea;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Idea>
 *
 * @method Idea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Idea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Idea[]    findAll()
 * @method Idea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdeaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Idea::class);
    }

    public function save(Idea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Idea $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllIdeasWithAuthorAndLike(): array
    {
        $query = $this->createQueryBuilder('i')
            ->addSelect('a', 'l') //to make Doctrine actually use the join
            ->leftJoin('i.author', 'a')
            ->leftJoin('i.likes', 'l')
            ->orderBy('i.id', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllCommentByIdea(): array
    {
        $query = $this->createQueryBuilder('i')
            ->Join('i.comments', 'c')
            ->groupBy('i.id')
            ->orderBy("count('i.comments')", 'DESC')
            ->setMaxResults(10)
            ->getQuery();


        return $query->getResult();
    }

    public function findAllIdeaLike(User $user): array
    {
        $query = $this->createQueryBuilder('i')
            ->addSelect('a') //to make Doctrine actually use the join
            ->Join('i.author', 'a')
            ->join('i.likes', 'l')
            ->andWhere('l.user = :val')
            ->setParameter('val', $user)
            ->orderBy('i.id', 'DESC')
            ->getQuery();

        return $query->getResult();
    }

    public function mostLikedIdeas(): array
    {
        $query = $this->createQueryBuilder('i')
            ->select('i', 'a')
            ->leftJoin('i.author', 'a')
            ->leftJoin('i.likes', 'l')
            ->groupBy('i.id')
            ->orderBy("count('l.idea')", 'DESC')
            ->setMaxResults(10)
            ->getQuery();


        return $query->getResult();
    }


    //    /**
    //     * @return Idea[] Returns an array of Idea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    /**
    //     * @return Idea[] Returns an array of Idea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }
    //    public function findOneBySomeField($value): ?Idea
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
