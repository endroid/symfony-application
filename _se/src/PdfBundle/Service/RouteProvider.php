<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PdfBundle\Service;

use RouteBundle\Entity\Route;
use RouteBundle\Provider\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class RouteProvider implements RouteProviderInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        $routes = [];

        $route = new Route();
        $route->setLabel('PDF');
        $route->setKey('pdf_pdf_index');
        $route->setName('pdf_pdf_index');
        $routes['pdf_pdf_index'] = $route;

        return $routes;
    }
}
