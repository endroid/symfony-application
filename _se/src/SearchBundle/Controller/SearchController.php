<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SearchBundle\Controller;

use Elastica\Filter\Missing;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Exists;
use Elastica\Query\QueryString;
use Elastica\Query\Terms;
use FOS\ElasticaBundle\Elastica\Index;
use Pagerfanta\Adapter\ElasticaAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $currentPage = $request->query->get('page', 1);
        $maxPerPage = 5;

        $search = $request->query->get('search');

        $queryString = new QueryString();
        $queryString->setQuery('*'.$search.'*');


        // Published is true or missing
        $publishedFilter = new Terms();
        $publishedFilter->setTerms('published', ['true']);

        $publishedMissingFilter = new BoolQuery();
        $publishedMissingFilter->addMustNot(new Exists('published'));

        $publishedOrFilter = new BoolQuery();
        $publishedOrFilter->addShould($publishedFilter);
        $publishedOrFilter->addShould($publishedMissingFilter);

        // Locale is current locale or missing
        $localeFilter = new Terms();
        $localeFilter->setTerms('locale', [$request->getLocale()]);

        $localeMissingFilter = new BoolQuery();
        $localeMissingFilter->addMustNot(new Exists('locale'));

        $localeOrFilter = new BoolQuery();
        $localeOrFilter->addShould($localeFilter);
        $localeOrFilter->addShould($localeMissingFilter);

        // Combine filters
        $filter = new BoolQuery();
        $filter->addMust($publishedOrFilter);
        $filter->addMust($localeOrFilter);

        $query = new Query();
        $query->setQuery($queryString);
        $query->setPostFilter($filter);

        $adapter = new ElasticaAdapter($this->getIndex(), $query);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($currentPage);

        return [
            'search' => $search,
            'pager' => $pager,
        ];
    }

    /**
     * Returns the index.
     *
     * @return Index
     */
    protected function getIndex()
    {
        return $this->get('fos_elastica.index.'.$this->container->getParameter('elasticsearch_index'));
    }
}
