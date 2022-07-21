<?php

namespace App\Repository;

use App\Entity\Campaign;
use App\Entity\Resolution;
use App\Entity\Voter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voter>
 *
 * @method Voter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voter[]    findAll()
 * @method Voter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voter::class);
    }

    public function add(Voter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Voter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getVotersWithPercentagesGranted(Campaign $campaign): array
    {
        return $this->createQueryBuilder('voter')
            ->join('voter.campaign', 'c', 'WITH', 'c = :campaign')
            ->setParameter('campaign', $campaign)
            ->where('voter.votePercentage > 0')
            ->getQuery()
            ->getResult();
    }

    public function getVotersAbstained(Resolution $resolution): array
    {
        return $this->createQueryBuilder('voter')
            ->leftJoin('voter.votes', 'votes', 'WITH', 'votes.resolution = :resolution')
            ->setParameter('resolution', $resolution)
            ->andWhere('votes.voter IS NULL')
            ->andWhere('voter.campaign=:campaign')
            ->setParameter('campaign', $resolution->getCampaign())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Voter[] Returns an array of Voter objects
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

//    public function findOneBySomeField($value): ?Voter
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
