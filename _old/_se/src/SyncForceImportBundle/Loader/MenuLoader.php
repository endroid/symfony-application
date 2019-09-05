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

class MenuLoader extends AbstractLoader
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
        // TODO: Implement load() method.
    }
}
