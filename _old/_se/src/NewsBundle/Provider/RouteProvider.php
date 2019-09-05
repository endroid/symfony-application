<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Provider;

use Doctrine\ORM\EntityRepository;
use NewsBundle\Entity\ArticleTranslation;
use RouteBundle\Entity\Route;
use RouteBundle\Provider\RouteProviderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

class RouteProvider implements ContainerAwareInterface, RouteProviderInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        $routes = [];

        /* @var ArticleTranslation[] $articles */
        $translations = $this->getArticleTranslationRepository()->findAll();

        $routeList = new Route();
        $routeList->setLabel(($this->getCurrentRequest()->getLocale() == 'nl') ? 'Nieuws' : 'News');
        $routeList->setKey('news_article_index');
        $routeList->setName('news_article_index');
        $routes['news_article_index'] = $routeList;

        foreach ($translations as $translation) {
            $routeDetail = new Route();
            $routeDetail->setLabel($translation->getTitle());
            $routeDetail->setKey('news_article_show_'.$translation->getId());
            $routeDetail->setName('news_article_show');
            $routeDetail->setParameters(['slug' => $translation->getSlug()]);
            $routes['news_article_show_'.$translation->getId()] = $routeDetail;
        }

        return $routes;
    }

    /**
     * Returns the article translation repository.
     *
     * @return EntityRepository
     */
    protected function getArticleTranslationRepository()
    {
        return $this->container->get('doctrine')->getRepository('NewsBundle:ArticleTranslation');
    }

    /**
     * Returns the current request.
     *
     * @return Request
     */
    protected function getCurrentRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
}
