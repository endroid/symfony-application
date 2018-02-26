<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{
    /**
     * @Given /^I make a screenshot$/
     */
    public function iMakeAScreenshot(): void
    {
        $imageData = $this->getSession()->getScreenshot();

        file_put_contents(__DIR__.'/../screenshots/'.date('U').'.png', $imageData);
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
}
