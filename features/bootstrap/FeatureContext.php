<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FeatureContext extends MinkContext
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario
     */
    public function loadFixtures()
    {
        $command = $this->kernel->getProjectDir().'/bin/console doctrine:fixtures:load --env=test -n -q';

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * @AfterStep
     */
    public function takeScreenshotAfterFailedStep(AfterStepScope $event)
    {
        if (!$event->getTestResult()->isPassed()) {
            $this->iMakeAScreenshot('-' . $event->getSuite()->getName() . '-' . $event->getStep()->getLine());
        }
    }

    /**
     * @Given /^I make a screenshot$/
     */
    public function iMakeAScreenshot(string $title = 'screenshot'): void
    {
        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            echo 'Use the Selenium2 driver to take a screenshot';
            return;
        }

        $imageData = $this->getSession()->getScreenshot();

        file_put_contents(__DIR__.'/../screenshots/'.date('U').'-'.$title.'.png', $imageData);
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
     * @Given /^I wait (\d+.\d+) seconds?$/
     */
    public function iWaitSeconds(float $seconds): void
    {
        usleep($seconds * 1000000);
    }
}
