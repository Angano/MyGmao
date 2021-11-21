<?php

namespace App\Repository;

use App\Entity\Materieltype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Materieltype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materieltype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materieltype[]    findAll()
 * @method Materieltype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterieltypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materieltype::class);
    }

    // /**
    //  * @return Materieltype[] Returns an array of Materieltype objects
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
    public function findOneBySomeField($value): ?Materieltype
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByMarque($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.marque like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByCategorie($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.categorie like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findCategorie($value)
    {
        $datas = $this->createQueryBuilder('c')
            ->andWhere('c.categorie like :val')
            ->select('c.categorie as nom')
            ->distinct()
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getScalarResult();

        return (json_encode($datas));
    }
}
