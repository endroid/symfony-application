<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MenuBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class MenuExtension extends Twig_Extension implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('route', [$this, 'route']),
        ];
    }

    /**
     * Returns the route with the given key.
     *
     * @param $key
     *
     * @return mixed
     */
    public function route($key)
    {
        $route = $this->container->get('route.collector')->getRouteByKey($key);

        return $route;
    }
}
