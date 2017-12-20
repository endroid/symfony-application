<?php

namespace NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NewsBundle\Entity\Article;
use NewsBundle\Entity\ArticleTranslation;

class ArticleRepository extends EntityRepository
{
    /**
     * Finds a paged set of article translations.
     *
     * @param $pageNumber
     * @param $pageSize
     *
     * @return ArticleTranslation[]
     */
    public function findPaged($pageNumber, $pageSize)
    {
        $query = $this->createQueryBuilder('translation')
            ->setFirstResult(($pageNumber - 1) * $pageSize)
            ->setMaxResults($pageSize)
            ->getQuery()
        ;

        return $query->getResult();
    }

    /**
     * Returns the total number of articles.
     *
     * @return int
     */
    public function count()
    {
        $query = $this->createQueryBuilder('translation')
            ->select('COUNT(translation.id)')
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
            ->addSelect('translatable')
            ->join($alias.'.translatable', 'translatable')
            ->orderBy('translatable.date', 'DESC')
        ;

        return $queryBuilder;
    }
}
