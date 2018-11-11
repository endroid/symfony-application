<?php

use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FeatureContext extends MinkContext
{
    /**
     * @BeforeSuite
     * @AfterScenario @reset
     */
    public static function reset()
    {
        passthru('bin/console doctrine:fixtures:load --purge-with-truncate -n -q');
        passthru('bin/console fos:elastica:populate -n -q');
    }

    /**
     * @Given /^I wait (\d+(.\d+)?) seconds?$/
     */
    public function iWaitSeconds(float $seconds): void
    {
        usleep($seconds * 1000000);
    }
}
