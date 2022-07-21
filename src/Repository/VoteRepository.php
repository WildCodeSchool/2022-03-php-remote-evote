<?php

namespace App\Repository;

use App\Entity\Vote;
use App\Entity\College;
use App\Entity\Resolution;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Vote>
 *
 * @method Vote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vote[]    findAll()
 * @method Vote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    public function add(Vote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vote $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getVotesByCollege(Resolution $resolution, College $college, string $answer): array
    {
        return $this->createQueryBuilder('v')
        ->join('v.resolution', 'r', 'WITH', 'v.resolution=:resolution')
        ->setParameter('resolution', $resolution)
        ->join('v.voter', 'voter')
        ->join('voter.college', 'c', 'WITH', 'voter.college=:college')
        ->setParameter('college', $college)
        ->where('v.answer=:answer')
        ->setParameter('answer', $answer)
        ->getQuery()
        ->getResult();
    }


//    /**
//     * @return Vote[] Returns an array of Vote objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vote
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
