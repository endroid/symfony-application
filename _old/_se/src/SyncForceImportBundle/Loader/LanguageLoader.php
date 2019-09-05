<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SyncForceImportBundle\Loader;

use Endroid\Import\Loader\AbstractLoader;

class LanguageLoader extends AbstractLoader
{
    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->state->set('languages', ['nl', 'en', 'de', 'fr', 'es', 'it']);
        $this->state->set('languages', ['nl', 'en']);
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $languages = $this->state->get('languages');

        if (count($languages) == 0) {
            $this->importer->setCompleted();
            return;
        }

        $this->state->set('language', array_shift($languages));
        $this->state->set('languages', $languages);

        $this->importer->setActiveLoader(ProductWebsiteCollectionLoader::class);
    }
}
