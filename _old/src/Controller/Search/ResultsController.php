<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Search;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ResultsController
{
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @Route("/search/results", name="search_results")
     */
    public function __invoke(Request $request): Response
    {
        $query = $request->query->get('query');

        $results = []; // Fetch from domain

        $response = new Response($this->templating->render('search/results.html.twig', [
            'query' => $query,
            'results' => $results,
        ]));

        return $response;
    }
}
