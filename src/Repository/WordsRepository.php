<?php

namespace App\Repository;

use App\Entity\Words;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WordsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Words::class);
    }
    public function findAllWords(): array
    {
        return $this->createQueryBuilder('w')
            ->select('w.content')
            ->getQuery()
            ->getScalarResult();
    }
}
