<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Endroid\Bundle\BehaviorBundle\Model\SortableInterface;
use Endroid\Bundle\BehaviorBundle\Model\SortableTrait;
use Endroid\Bundle\BehaviorBundle\Model\TraversableInterface;
use Endroid\Bundle\BehaviorBundle\Model\TraversableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu_item")
 */
class MenuItem implements SortableInterface, TraversableInterface
{
    use SortableTrait;
    use TraversableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $routeKey;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $tag;

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
     * Sets the route key.
     *
     * @param $routeKey
     *
     * @return MenuItem
     */
    public function setRouteKey($routeKey)
    {
        $this->routeKey = $routeKey;

        return $this;
    }

    /**
     * Returns the route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return $this->routeKey;
    }

    /**
     * Sets the tag.
     *
     * @param $tag
     *
     * @return MenuItem
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Returns the tag.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->tag);
    }
}
