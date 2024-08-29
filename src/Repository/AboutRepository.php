<?php

namespace App\Repository;

use App\Entity\About;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AboutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, About::class);
    }

    public function findMostRecent(): ?About
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
