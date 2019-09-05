<?php

namespace SearchBundle\Features\Context;

use AppBundle\Features\Context\FeatureContext as AppFeatureContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Feature context.
 */
class FeatureContext extends AppFeatureContext
{
    use KernelDictionary;
}
