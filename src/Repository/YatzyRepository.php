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
    

}

