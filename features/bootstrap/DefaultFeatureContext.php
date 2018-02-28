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

class DefaultFeatureContext extends MinkContext
{
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
            return;
        }

        $imageData = $this->getSession()->getScreenshot();

        file_put_contents(__DIR__.'/../screenshots/'.date('U').'-'.$title.'.png', $imageData);
    }

    /**
     * @Then /^I should see "([^"]*)" in the header "([^"]*)"$/
     */
    public function iShouldSeeInTheHeader(string $value, string $header): void
    {
        $header = strtolower($header);
        $headers = $this->getSession()->getResponseHeaders();

        if (!isset($headers[$header][0]) || strpos($headers[$header][0], $value) === false) {
            throw new \Exception(sprintf('Did not see header '.$header.' with value '.$value, $header, $value));
        }
    }

    /**
     * @Given /^I wait (\d+.\d+) seconds?$/
     */
    public function iWaitSeconds(float $seconds): void
    {
        usleep($seconds * 1000000);
    }
}
