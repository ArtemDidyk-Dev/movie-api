<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Movie;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findRandom()
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m')
            ->orderBy('RAND()')
            ->setMaxResults(1);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
