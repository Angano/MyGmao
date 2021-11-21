<?php

namespace App\Repository;

use App\Entity\Technicien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Technicien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Technicien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Technicien[]    findAll()
 * @method Technicien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Technicien::class);
    }

    // /**
    //  * @return Technicien[] Returns an array of Technicien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Technicien
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByMetier($value)
    {
        $datas = $this->createQueryBuilder('m')
            ->andWhere('m.metier like :val')
            ->setParameter('val', '%' . $value . '%')
            ->setMaxResults(10)
            ->orderBy('m.id', 'ASC')
            ->groupBy('m.metier')
            ->getQuery()
            ->getResult();
        $tab = [];
        foreach ($datas as $data) {
            array_push($tab, $data->getMetier());
        }
        return json_encode($tab, JSON_UNESCAPED_UNICODE);
    }

    public function findMetierAll()
    {
        $datas = $this->createQueryBuilder('m')
            ->groupBy('m.metier')
            ->getQuery()
            ->getResult();

        $tab = [];
        foreach ($datas as $data) {
            array_push($tab, $data->getMetier());
        }
        return json_encode($tab, JSON_UNESCAPED_UNICODE);
    }
}
