<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="NewsBundle\Repository\ArticleCategoryRepository")
 * @ORM\Table(name="news_article_category")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class ArticleCategory
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Serializer\Expose
     */
    protected $id;

    /**
     * Returns the ID.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return '#'.$this->id;
    }
}
