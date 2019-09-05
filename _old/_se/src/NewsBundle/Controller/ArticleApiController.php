<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use League\Tactician\CommandBus;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use NewsBundle\Form\Type\ArticleType;
use NewsBundle\Entity\Article;
use NewsBundle\Handler\ArticleHandler;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArticleApiController extends FOSRestController
{
    /**
     * Lists all articles.
     *
     * @ApiDoc(
     *   section="News",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when unauthorized"
     *   }
     * )
     *
     * @Security("has_role('ROLE_API')")
     *
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="Number of items to return.")
     * @Annotations\QueryParam(name="offset", requirements="\d+", default="0", description="Offset of first item to return.")
     *
     * @Annotations\View(statusCode=200)
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array
     */
    public function getArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        $limit = $paramFetcher->get('limit', 5);
        $offset = $paramFetcher->get('offset', 0);

        $articles = $this->getArticleHandler()->getAll($limit, $offset);

        return $articles;
    }

    /**
     * Returns an article.
     *
     * @Security("has_role('ROLE_API')")
     *
     * @ApiDoc(
     *   section="News",
     *   resource = true,
     *   requirements = {
     *       { "name"="id", "dataType"="integer", "requirement"="\d+", "description"="The article ID" }
     *   },
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when unauthorized",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(statusCode=200)
     *
     * @param int $id
     *
     * @return Article
     */
    public function getArticleAction($id)
    {
        $article = $this->getArticleHandler()->get($id);

        return $article;
    }

    /**
     * Creates an article.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   section="News",
     *   resource = true,
     *   input = "NewsBundle\Form\Type\ArticleType",
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     201 = "Returned when the article is created",
     *     400 = "Returned when the request is invalid",
     *     401 = "Returned when unauthorized"
     *   }
     * )
     *
     * @Annotations\View(statusCode=201)
     *
     * @param Request $request
     *
     * @return Article
     */
    public function postArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(new ArticleType(), $article);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return View::create($form->getErrors(true, false), 400);
        }

        $article = $form->getData();
        $this->getArticleHandler()->save($article);

        return $article;
    }

    /**
     * Updates an article.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   section="News",
     *   resource = true,
     *   input = "NewsBundle\Form\Type\ArticleType",
     *   output = "NewsBundle\Entity\Article",
     *   statusCodes = {
     *     201 = "Returned when the article is updated",
     *     400 = "Returned when the request is invalid",
     *     401 = "Returned when unauthorized",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(statusCode=201)
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Article
     */
    public function putArticleAction(Request $request, $id)
    {
        $article = $this->getArticleHandler()->get($id);

        $form = $this->createForm(new ArticleType(), $article, ['method' => 'PUT']);

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return View::create($form->getErrors(true, false), 400);
        }

        $article = $form->getData();
        $this->getArticleHandler()->save($article);

        return $article;
    }

    /**
     * Deletes all articles.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   section="News",
     *   statusCodes = {
     *     204 = "Returned when the articles are removed",
     *     400 = "Returned when the request is invalid",
     *     401 = "Returned when unauthorized"
     *   }
     * )
     *
     * @Annotations\View(statusCode=204)
     */
    public function deleteArticlesAction()
    {
        $this->getArticleHandler()->deleteAll();
    }

    /**
     * Deletes an article.
     *
     * @Security("has_role('ROLE_API_ADMIN')")
     *
     * @ApiDoc(
     *   section="News",
     *   statusCodes = {
     *     204 = "Returned when the article is removed",
     *     400 = "Returned when the request is invalid",
     *     401 = "Returned when unauthorized",
     *     404 = "Returned when the article is not found"
     *   }
     * )
     *
     * @Annotations\View(statusCode=204)
     *
     * @param $id
     */
    public function deleteArticleAction($id)
    {
        $article = $this->getArticleHandler()->get($id);

        $this->getArticleHandler()->delete($article);
    }

    /**
     * Returns the article handler.
     *
     * @return ArticleHandler
     */
    protected function getArticleHandler()
    {
        return $this->get('news.handler.article_handler');
    }

    /**
     * Returns the command bus.
     *
     * @return CommandBus
     */
    protected function getCommandBus()
    {
        return $this->get('tactician.commandbus');
    }
}
