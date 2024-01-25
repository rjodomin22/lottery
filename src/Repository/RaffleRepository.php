<?php

namespace App\Repository;

use App\Entity\Raffle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Raffle>
 *
 * @method Raffle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Raffle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Raffle[]    findAll()
 * @method Raffle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaffleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Raffle::class);
    }

    //    /**
    //     * @return Raffle[] Returns an array of Raffle objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Raffle
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
   /*  public function findTicketsWithNullBuyerId(int $raffleId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT * FROM  t
         JOIN t.raffle r
         WHERE r.id = :raffleId
         AND t.buyer_id IS NULL'
        )->setParameter('raffleId', $raffleId);
        return $query->getResult();
    } */
    public function findFinishedRaffles(): array
       {
        $value =  new \DateTime();
           return $this->createQueryBuilder('r')
               ->andWhere('r.dateTime < :val')
               ->andWhere('r.winner IS NULL')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }
       public function findOpensRaffles(): array
       {
        $value =  new \DateTime();
           return $this->createQueryBuilder('r')
               ->andWhere('r.dateTime > :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }
}
