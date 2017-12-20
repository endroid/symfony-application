<?php

namespace ApiBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use OAuthBundle\Command\CreateClientCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
    use KernelDictionary;

    protected $clientId;
    protected $clientSecret;
    protected $accessToken;

    /**
     * @Given /^I create a client id and secret$/
     */
    public function iCreateAClientIdAndSecret()
    {
        $command = new CreateClientCommand();
        $command->setContainer($this->kernel->getContainer());
        $input = new ArrayInput(['--grant-type' => ['client_credentials']]);
        $output = new BufferedOutput();
        $command->run($input, $output);

        $result = $output->fetch();

        $this->clientId = preg_replace('#.*Client ID: ([0-9]+_[a-z0-9]+).*#is', '$1', $result);
        $this->clientSecret = preg_replace('#.*Client secret: ([a-z0-9]+).*#is', '$1', $result);

        if (!$this->clientId || !$this->clientSecret) {
            throw new \Exception('No valid client id and / or secret returned');
        }
    }

    /**
     * @Given /^I retrieve an access token$/
     */
    public function iRetrieveAnAccessToken()
    {
        $this->getSession()->visit('/oauth/v2/token?client_id='.$this->clientId.'&client_secret='.$this->clientSecret.'&grant_type=client_credentials');

        $response = $this->getSession()->getPage()->getContent();
        $json = json_decode($response);

        if (!$json || !$json->access_token) {
            throw new \Exception('No valid JSON returned');
        }

        $this->accessToken = $json->access_token;
    }

    /**
     * @Then /^I should be able to perform an API call$/
     */
    public function iShouldBeAbleToPerformAnApiCall()
    {
        $this->getSession()->visit('/api/pages/1.json?access_token='.$this->accessToken);

        $response = $this->getSession()->getPage()->getContent();
        $json = json_decode($response);

        if (!$json || (isset($json->error) && $json->error == 'invalid_grant')) {
            throw new \Exception('Invalid grant');
        }
    }
}
