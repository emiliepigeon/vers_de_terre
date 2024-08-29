<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCategories(array $categories, int $limit = null, int $offset = null): array
    {
        $qb = $this->createQueryBuilder('a')
            ->andWhere('a.category IN (:categories)')
            ->setParameter('categories', $categories)
            ->orderBy('a.createdAt', 'DESC');

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        if ($offset !== null) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getResult();
    }

    public function countByCategories(array $categories): int
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.category IN (:categories)')
            ->setParameter('categories', $categories)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllByCategories(array $categories): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.category IN (:categories)')
            ->setParameter('categories', $categories)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findLatestArticles(int $limit = 5): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findBySlug(string $slug): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
