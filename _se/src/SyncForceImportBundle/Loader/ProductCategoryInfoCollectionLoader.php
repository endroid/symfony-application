<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SyncForceImportBundle\Loader;

use Endroid\Import\Loader\AbstractLoader;
use SyncForceImportBundle\Client\SyncForceClient;
use XmlIterator\XmlIterator;

class ProductCategoryInfoCollectionLoader extends AbstractLoader
{
    /**
     * @var SyncForceClient
     */
    protected $client;

    /**
     * @param SyncForceClient $client
     */
    public function __construct(SyncForceClient $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $language = $this->state->get('language');

        $data = $this->client->getProductCategoryInfoCollectionData($language);
        $this->state->set('product_category_info_collection_data', $data);

        $this->importer->setActiveLoader(ProductLoader::class);
    }
}
