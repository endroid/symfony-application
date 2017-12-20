<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SearchBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;

class SearchExtension extends Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('class', [$this, 'classFilter']),
        ];
    }

    /**
     * Returns the class of the current object.
     *
     * @param $object
     *
     * @return string
     */
    public function classFilter($object)
    {
        return get_class($object);
    }
}
