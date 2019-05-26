<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Behatch\Context\RestContext;

class JwtFeatureContext implements Context
{
    /** @var RestContext */
    private $restContext;

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
    }

    /**
     * @Given /^I retrieve a JWT token for user "([^"]*)" with password "([^"]*)"$/
     */
    public function iRetrieveAJWTTokenForUserWithPassword($username, $password)
    {
        $data = new TableNode([
            ['key', 'value'],
            ['_username', $username],
            ['_password', $password],
        ]);

        $this->restContext->iSendARequestToWithParameters('POST', '/api/login_check', $data);

        $response = json_decode($this->restContext->getSession()->getDriver()->getContent(), true);

        if (!isset($response['token'])) {
            dump($response);
        }

        $this->restContext->iAddHeaderEqualTo('Authorization', 'Bearer '.$response['token']);
    }
}
