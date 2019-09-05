<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PageBundle\Provider;

use Doctrine\ORM\EntityRepository;
use PageBundle\Entity\PageTranslation;
use RouteBundle\Entity\Route;
use RouteBundle\Provider\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class RouteProvider implements ContainerAwareInterface, RouteProviderInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        $routes = [];

        /* @var PageTranslation[] $pages */
        $translations = $this->getPageTranslationRepository()->findAll();

        foreach ($translations as $translation) {
            $routeDetail = new Route();
            $routeDetail->setLabel($translation->getTitle());
            $routeDetail->setKey('page_page_show_'.$translation->getId());
            $routeDetail->setName('page_page_show');
            $routeDetail->setParameters(['slug' => $translation->getSlug()]);
            $routes['page_page_show_'.$translation->getId()] = $routeDetail;
        }

        return $routes;
    }

    /**
     * Returns the page translation repository.
     *
     * @return EntityRepository
     */
    protected function getPageTranslationRepository()
    {
        return $this->container->get('doctrine')->getRepository('PageBundle:PageTranslation');
    }
}
