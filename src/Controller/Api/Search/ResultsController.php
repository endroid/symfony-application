<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Api\Search;

use FOS\RestBundle\Controller\Annotations\View;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController
{
    /**
     * @Route("/api/search", name="api_search", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Search results for the given query"
     * )
     *
     * @SWG\Parameter(
     *     name="query",
     *     in="query",
     *     type="string",
     *     description="Search query"
     * )
     *
     * @SWG\Tag(name="search")
     *
     * @View(statusCode=200)
     */
    public function __invoke(Request $request): Response
    {
        $query = $request->query->get('query');

        return new JsonResponse([
            'query' => $query,
            'results' => [],
        ]);
    }
}
