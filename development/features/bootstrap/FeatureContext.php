<?php

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{
    /**
     * @BeforeSuite
     * @AfterScenario @reset
     */
    public static function reset()
    {
        passthru('bin/console doctrine:database:create --if-not-exists -q');
        passthru('bin/console doctrine:migrations:migrate -n -q');
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
