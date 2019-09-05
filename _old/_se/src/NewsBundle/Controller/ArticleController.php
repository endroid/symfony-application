<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Controller;

use NewsBundle\Entity\ArticleTranslation;
use NewsBundle\Repository\ArticleRepository;
use Pagerfanta\Adapter\FixedAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $currentPage = $request->query->get('page', 1);
        $maxPerPage = 5;

        $articles = $this->getArticleRepository()->findPaged($currentPage, $maxPerPage);
        $articleCount = $this->getArticleRepository()->count();

        $adapter = new FixedAdapter($articleCount, $articles);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($currentPage);

        return [
            'pager' => $pager,
        ];
    }

    /**
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction(ArticleTranslation $article)
    {
        return [
            'article' => $article,
        ];
    }

    /**
     * Returns the article repository.
     *
     * @return ArticleRepository
     */
    protected function getArticleRepository()
    {
        return $this->getDoctrine()->getRepository('NewsBundle:ArticleTranslation');
    }
}
