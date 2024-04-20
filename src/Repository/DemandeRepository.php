<?php

namespace App\Repository;

use App\Entity\Demande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Demande>
 *
 * @method Demande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Demande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Demande[]    findAll()
 * @method Demande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Demande::class);
        $this->entityManager = $entityManager;
    }

//    public function findDemandesWithStatusNotIn()
//    {
//        $queryBuilder = $this->entityManager->createQueryBuilder();
//
//        return $queryBuilder
//            ->select('d')
//            ->from(Demande::class, 'd')
//            ->where($queryBuilder->expr()->notIn(2,3))
//            ->getQuery()
//            ->getResult();
//    }


    public function findDemandesWithStatusNotIn(): array
    {
        return $this->createQueryBuilder('d')
            ->select('MONTH(d.date_updated) as month, count(d.id) as count')
            ->andWhere('d.status!=3 and d.status!=4')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function countDemandeByClasse(): array
    {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d) nb', 'u.niveau')
            //->from('App\Entity\Demande', 'd')
            ->join('d.id_user', 'u')
            ->groupBy('u.niveau')
            ->getQuery()
            ->getResult();

    }


//    /**
//     * @return DemandeFixtures[] Returns an array of DemandeFixtures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeFixtures
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
