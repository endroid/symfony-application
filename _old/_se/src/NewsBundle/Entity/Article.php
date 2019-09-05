<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity()
 * @ORM\Table(name="news_article")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class Article
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
     * @ORM\Column(type="date")
     *
     * @Serializer\Exclude
     */
    protected $date;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ArticleCategory")
     */
    protected $categories;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

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
     * Sets the date.
     *
     * @param $date
     *
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Returns the date.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the categories.
     *
     * @param ArticleCategory[] $categories
     */
    public function setCategories(array $categories)
    {
        $this->categories->clear();

        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * Adds a category.
     *
     * @param ArticleCategory $category
     *
     * @return $this
     */
    public function addCategory(ArticleCategory $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * Returns the categories.
     *
     * @return ArticleCategory[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return '#'.$this->id;
    }
}
