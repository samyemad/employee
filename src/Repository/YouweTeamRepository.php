<?php

namespace App\Repository;

use App\Entity\YouweTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<YouweTeam>
 *
 * @method YouweTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method YouweTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method YouweTeam[]    findAll()
 * @method YouweTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YouweTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YouweTeam::class);
    }

    public function add(YouweTeam $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(YouweTeam $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return YouweTeam[] Returns an array of YouweTeam objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('y')
//            ->andWhere('y.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('y.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?YouweTeam
//    {
//        return $this->createQueryBuilder('y')
//            ->andWhere('y.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
