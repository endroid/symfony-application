<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FeatureContext extends MinkContext
{
    /**
     * @BeforeScenario
     */
    public function loadFixtures()
    {
        $command = 'bin/console doctrine:fixtures:load --purge-with-truncate --env=test -n -q';

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * @Then /^I should see "([^"]*)" in the header "([^"]*)"$/
     */
    public function iShouldSeeInTheHeader(string $content, string $header): void
    {
        $header = strtolower($header);
        $headers = $this->getSession()->getResponseHeaders();

        foreach ($headers as $name => $values) {
            foreach ((array) $values as $value) {
                if (strpos($value, $content) !== false) {
                    return;
                }
            }
        }

        throw new \Exception(sprintf('Did not see header "%s" with content "%s"', $header, $content));
    }

    /**
     * @Given /^I wait (\d+(.\d+)?) seconds?$/
     */
    public function iWaitSeconds(float $seconds): void
    {
        usleep($seconds * 1000000);
    }
}
