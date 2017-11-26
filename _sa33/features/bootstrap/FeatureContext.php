<?php

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{
    /**
     * @Given /^I make a screenshot$/
     */
    public function iMakeAScreenshot()
    {
        $imageData = $this->getSession()->getScreenshot();

        file_put_contents(__DIR__.'/../screenshots/'.date('U').'.png', $imageData);
    }
}
