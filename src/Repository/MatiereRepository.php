<?php

namespace App\Repository;

use App\Entity\Matiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Matiere>
 *
 * @method Matiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matiere[]    findAll()
 * @method Matiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matiere::class);
    }

    /**
     * @return Matiere[] Returns an array of MatiereFixtures objects
     */
    public function findMatiereByUser($userId): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.designation, m.id')
            ->leftJoin('m.classes', 'classe')
            ->leftJoin('classe.users', 'user')
            ->where('user.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
    public function findMatiereByUserQueryBuilder($userId): QueryBuilder
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.classes', 'classe')
            ->leftJoin('classe.users', 'user')
            ->where('user.id = :userId')
            ->setParameter('userId', $userId)
           ;
    }


        public function findSousMatieresByMatiere(Matiere $matiere)
        {
        return $matiere->getSousMatiere();
    }




//    public function findOneBySomeField($value): ?MatiereFixtures
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
