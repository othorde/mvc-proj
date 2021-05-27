<?php

namespace App\Repository;

use App\Entity\Yatzy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Yatzy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Yatzy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Yatzy[]    findAll()
 * @method Yatzy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YatzyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Yatzy::class);
    }



   public function findAllnames(): array
    {
        $entityManager = $this->getEntityManager();
        $price = 0;
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Yatzy p
            WHERE p.name and p.id
           '
        )->setParameter('price', $price);

        // returns an array of Product objects
        return $query->getResult();
    }












    // /**
    //  * @return Yatzy[] Returns an array of Yatzy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Yatzy
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
