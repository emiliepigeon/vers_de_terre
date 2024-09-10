<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
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

    public function findByCategory(array $categories, int $limit = null, int $offset = null): array
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

    public function findByCategories(array $categories, int $limit = null): array
    {
        return $this->findByCategory($categories, $limit);
    }

    public function countByCategory(array $categories): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->andWhere('a.category IN (:categories)')
            ->setParameter('categories', $categories)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAllByCategory(array $categories): array
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

    public function findBySlug(string $slug): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getResult();
    }

    public function findLatestFromDifferentCategories(array $categories, int $limit = 3): array
    {
        $qb = $this->createQueryBuilder('a');
        
        $qb->where($qb->expr()->in('a.category', ':categories'))
            ->setParameter('categories', $categories)
            ->orderBy('a.createdAt', 'DESC');

        $results = $qb->getQuery()->getResult();

        $categoriesUsed = [];
        $finalResults = [];

        foreach ($results as $article) {
            $categoryId = $article->getCategory()->getId();
            if (!in_array($categoryId, $categoriesUsed) && count($finalResults) < $limit) {
                $finalResults[] = $article;
                $categoriesUsed[] = $categoryId;
            }
            if (count($finalResults) >= $limit) {
                break;
            }
        }

        // Si on a moins d'articles que la limite, on complète avec d'autres articles
        if (count($finalResults) < $limit) {
            foreach ($results as $article) {
                if (!in_array($article, $finalResults) && count($finalResults) < $limit) {
                    $finalResults[] = $article;
                }
                if (count($finalResults) >= $limit) {
                    break;
                }
            }
        }

        return $finalResults;
    }
}
