<?php

namespace App\Repository;

use App\Entity\Highscore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Highscore|null find($id, $lockMode = null, $lockVersion = null)
 * @method Highscore|null findOneBy(array $criteria, array $orderBy = null)
 * @method Highscore[]    findAll()
 * @method Highscore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HighscoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Highscore::class);
    }

    // /**
    //  * @return Highscore[] Returns an array of Highscore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function setHighscore($resAndName): void
    {
        $newarr = [];
        foreach ($resAndName as $value => $id) {
            $value;
            $scoreAndName = array_values($id);
            array_push($newarr, $scoreAndName[0]);
            array_push($newarr, $scoreAndName[1]);
        }

        $len = (count($scoreAndName) / 2);
        for ($x = 0; $x <= $len; $x++) {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                'UPDATE App\Entity\Highscore h
                SET h.name = :names,
                h.score = :score
                '
            );
            $query->setParameter('names', strval($scoreAndName[1]));
            $query->setParameter('score', strval($scoreAndName[0]));
            $query->execute();
        }
        //var_dump($scoreAndName);
    }

    public function highscores(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT h.name, h.score, h.id
            FROM App\Entity\Highscore h'
        );
        $bla = $query->getResult();

        foreach ($bla as $elem) {
            $hej = $elem;
        }
        return $hej;
    }
}
