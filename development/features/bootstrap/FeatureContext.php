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
        passthru('bin/console doctrine:database:drop --if-exists --force -q --env=test');
        passthru('bin/console doctrine:database:create --if-not-exists -q --env=test');
        passthru('bin/console doctrine:migrations:migrate -n -q --env=test');
        passthru('bin/console doctrine:fixtures:load -n -q --env=test');
        passthru('bin/console fos:elastica:populate -n -q --env=test');
    }

    /**
     * @Given /^I wait (\d+(.\d+)?) seconds?$/
     */
    public function iWaitSeconds(float $seconds): void
    {
        usleep($seconds * 1000000);
    }
}
