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
 * @method Yatzy[]    findAllGreaterThanPrice(int $res)
 */
class YatzyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Yatzy::class);
    }


    /**
     * @return Yatzy[]
     */
    public function setValue($res): int
    {
        echo($res[2]);
        $score = strval($res[0]);
        $id = strval($res[1]);
        $que = $res[2];

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            $que
        );
        $que = "";
        $query->setParameter('id', strval($id));
        $query->setParameter('score', strval($score));

        return $query->execute();
    }


    public function checkSum($id): int
    {
         $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(

        'UPDATE App\Entity\Yatzy y 
        SET y.summa = y.ettor + y.tvaor + y.treor + y.fyror + y.femmor + y.sexor WHERE y.id = :id'
       );
        $query->setParameter('id', strval($id));

        return $query->execute();
    } 

    public function checkTotal($id): int
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(

        'UPDATE App\Entity\Yatzy y 
        SET y.totalt = y.ettor + y.tvaor + y.treor + y.fyror + y.femmor + y.sexor + y.bonus + y.par + y.parpar + y.tretal + y.fyrtal + y.straight + y.kak + y.sstraight + y.chans + y.yatzy WHERE y.id = :id'
       );
        $query->setParameter('id', strval($id));
        echo("HEJ");
        return $query->execute();
    }
    
    public function checkBonus($id): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT y.summa
            FROM App\Entity\Yatzy y
            WHERE y.id = :id'
        )->setParameter('id', $id);

        $hej =  $query->getResult();

        foreach ($hej as $value) {
            $blo = (array_values($value));
        }
        $hej = $blo[0];
        if($hej === null) {
            $hej = 0;
        }
        return $hej;
    }


    public function setBonus($id, $score): int {
        $bonus = 0;
        if ($score > 50) {
            $bonus = 50;
        }

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
        'UPDATE App\Entity\Yatzy y 
        SET y.bonus = :bonus WHERE y.id = :id'
       );
        $query->setParameter('id', strval($id));
        $query->setParameter('bonus', strval($bonus));

        return $query->execute();
    }

    public function getEndGameResult(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT y.totalt, y.name
            FROM App\Entity\Yatzy y'
        );

        $hej = $query->getResult();

        return $hej;
    }
   
}

