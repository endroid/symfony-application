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
        self::resetFixtures();
        self::resetElasticsearch();
    }

    private static function resetFixtures()
    {
        $command = 'bin/console doctrine:fixtures:load --env=test --purge-with-truncate -n -q';

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    private static function resetElasticsearch()
    {
        $command = 'bin/console fos:elastica:populate --env=test -n -q';

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * @Given /^I wait (\d+(.\d+)?) seconds?$/
     */
    public function iWaitSeconds(float $seconds): void
    {
        usleep($seconds * 1000000);
    }
}
