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

class ProductLoader extends AbstractLoader
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
     * @return array
     */
    public function load()
    {
        $product = $this->productRepository->updateOrCreateFromArray($data->code);
        $product->setName($data->brandName);
        $product->setCode($data->modelCode);
        $this->productRepository->save($product);

        $subProductGroup = $this->productRepository->updateOrCreateFromArray($data->code);
        $subProductGroup->setName($data->groupName);
        $this->productRepository->save($subProductGroup);

        $mainProductGroup = new MainProductGroup();

        dump($this->state);
        die;
        // TODO: Implement load() method.
    }
}
