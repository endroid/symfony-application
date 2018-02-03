<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Search;

use Elastica\Query;
use Elastica\Suggest\Completion;
use Elastica\Type;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class SuggestController
{
    private $searchable;
    private $templating;

    public function __construct(
        Type $searchable,
        Environment $templating
    )
    {
        $this->searchable = $searchable;
        $this->templating = $templating;
    }

    /**
     * @Route("/search/suggest", name="search_suggest", defaults={"_format": "json"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        $query = (string) $request->query->get('query');

        if (strlen($query) === 0) {
            throw new BadRequestHttpException(sprintf('Invalid search query "%s"', $query));
        }

        $completion = new Completion('search', 'suggest');
        $completion->setText($query);
        $completion->setFuzzy(['fuzziness' => 2]);
        $resultSet = $this->searchable->search(Query::create($completion));

        $suggestions = [];
        foreach ($resultSet->getSuggests() as $suggests) {
            foreach ($suggests as $suggest) {
                foreach ($suggest['options'] as $option) {
                    $suggestions[] = [
                        'id' => $option['_source']['id'],
                        'text' => $option['_source']['username']
                    ];
                }
            }
        }

        return new JsonResponse($suggestions);
    }
}
