<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    // /**
    //  * @return Intervention[] Returns an array of Intervention objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intervention
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findInterventionByClientSearch($value, $clos)
    {
        $query = $this->createQueryBuilder('i')
            ->join('i.client', 'c')
            ->andWhere('c.nom like :val')
            ->orWhere('c.societe like :val')
            ->setParameter('val', '%' . $value . '%');

        if ($clos == 'true' or $clos == 'false') :
            $query->andWhere('i.status = :clos')->setParameter('clos', filter_var($clos, FILTER_VALIDATE_BOOLEAN));
        endif;

        return $query->getQuery()->getResult();
    }


    public function findInterventionByTechicienSearch($value, $clos)
    {
        $query = $this->createQueryBuilder('i')
            ->join('i.technicien', 't')
            ->andWhere('t.nom like :val')
            ->setParameter('val', '%' . $value . '%');

        if ($clos == 'true' or $clos == 'false') :
            $query->andWhere('i.status = :clos')->setParameter('clos', filter_var($clos, FILTER_VALIDATE_BOOLEAN));
        endif;

        return $query->getQuery()->getResult();
    }

    public function findInterventionByMaterielSearch($value, $clos)
    {
        $query = $this->createQueryBuilder('i')
            ->join('i.materiel', 'm')
            ->join('m.materieltype', 't')
            ->andWhere('t.marque like :val')
            ->orWhere('t.modele like :val')
            ->setParameter('val', '%' . $value . '%');

        if ($clos == 'true' or $clos == 'false') :
            $query->andWhere('i.status = :clos')->setParameter('clos', filter_var($clos, FILTER_VALIDATE_BOOLEAN));
        endif;

        return $query->getQuery()->getResult();
    }


    // Recherche des interventions par client pour JS
    public function findInterventionByClient($value)
    {
        $datas = $this->createQueryBuilder('i')
            ->join('i.client', 'c')
            ->where('c.nom like :val')
            ->orWhere('c.societe like :val')
            ->groupBy('c.nom', 'c.societe')
            ->select('c.nom as nom', 'c.societe as societe')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
        return json_encode($datas);
    }

    public function findInterventionByTechicien($value)
    {
        $datas = $this->createQueryBuilder('i')
            ->join('i.technicien', 't')
            ->join('t.user', 'u')
            ->join('u.technicien', ('tec'))
            ->where('tec.nom like :val')
            ->groupBy('tec.nom')
            ->select('tec.nom as nom')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
        return json_encode($datas);
    }
}
