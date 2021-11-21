<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Materiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Materiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Materiel[]    findAll()
 * @method Materiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

    // /**
    //  * @return Materiel[] Returns an array of Materiel objects
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
    public function findOneBySomeField($value): ?Materiel
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByClient($value): ?array
    {
        // recherche par client, matériel ou categorie
        return $this->createQueryBuilder('m')
            ->select('m', 'c')
            ->join('m.client', 'c')
            ->where('c.societe like :val')
            ->orWhere('c.nom like :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }
    public function findByCategorie($value): ?array
    {
        // recherche par client, matériel ou categorie
        return $this->createQueryBuilder('m')
            ->select('m', 'c')
            ->join('m.materieltype', 'c')
            ->where('c.categorie like :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

    public function findByMateriel($value): ?array
    {
        // recherche par client, matériel ou categorie
        return $this->createQueryBuilder('m')
            ->select('m', 'c')
            ->join('m.materieltype', 'c')
            ->where('c.marque like :val')
            ->orWhere('c.modele like :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }


    public function findMarque($value)
    {
        // recherche par client, matériel ou categorie
        $datas =  $this->createQueryBuilder('m')
            ->select('m', 'c')
            ->join('m.materieltype', 'c')
            ->where('c.marque like :val')
            ->orWhere('c.modele like :val')
            ->select('c.marque as societe', 'c.modele as nom')
            ->distinct()
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();

        return json_encode($datas);
    }
}
