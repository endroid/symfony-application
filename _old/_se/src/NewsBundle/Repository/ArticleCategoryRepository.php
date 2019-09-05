<?php

namespace NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleCategoryRepository extends EntityRepository
{
    /**
     * Finds a paged set of articles.
     *
     * @param $pageNumber
     * @param $pageSize
     *
     * @return Article[]
     */
    public function findPaged($pageNumber, $pageSize)
    {
        $query = $this->createQueryBuilder('a')
            ->setFirstResult(($pageNumber - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
        ;

        return $query->getResult();
    }

    /**
     * Finds an article by its slug.
     *
     * @param $slug
     *
     * @return Article
     */
    public function findOneBySlug($slug)
    {
        $query = $this->createQueryBuilder('a')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
        ;

        return $query->getSingleResult();
    }

    /**
     * Returns the total number of articles.
     *
     * @return int
     */
    public function count()
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
        ;

        return $query->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        $queryBuilder = parent::createQueryBuilder($alias, $indexBy);

        $queryBuilder
            ->addSelect('t')
            ->join($alias.'.translations', 't')
            ->orderBy($alias.'.date', 'DESC')
        ;

        return $queryBuilder;
    }
}
