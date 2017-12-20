<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Features\Context;

use AppBundle\Features\Context\FeatureContext as AppContext;
use Behat\Behat\Hook\Call\AfterScenario;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\ORM\EntityManager;
use Exception;
use OAuthBundle\Entity\Client;
use OAuthBundle\Service\ClientService;
use UserBundle\Entity\User;

class FeatureContext extends AppContext
{
    use KernelDictionary;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @Given /^I create a client$/
     */
    public function iCreateAClient()
    {
        $this->createClient();
    }

    /**
     * @When /^I retrieve an access token$/
     */
    public function iRetrieveAnAccessToken()
    {
        $this->retrieveAccessToken();
    }

    /**
     * @Then /^I have an access token$/
     */
    public function iHaveAnAccessToken()
    {
        if (!$this->accessToken) {
            $this->removeClient();
            throw new Exception('No access token returned');
        }
    }

    /**
     * @Given /^I have an invalid access token$/
     */
    public function iHaveAnInvalidAccessToken()
    {
        $this->accessToken = 'invalid_token';
    }

    /**
     * @Given /^I have a valid access token$/
     */
    public function iHaveAValidAccessToken()
    {
        $this->createClient();
        $this->retrieveAccessToken();
    }

    /**
     * @When /^I set the authorization header$/
     */
    public function iSetTheAuthorizationHeader()
    {
        $this->getSession()->setRequestHeader('Authorization', 'Bearer '.$this->accessToken);
    }

    /**
     * Creates a client.
     */
    protected function createClient()
    {
        $this->client = $this->getClientService()->create([
            'grant_types' => ['client_credentials'],
        ]);

        /** @var EntityManager $manager */
        $manager = $this->get('doctrine')->getManager();

        /** @var User $user */
        $user = $manager->getRepository('UserBundle:User')->findOneByUsername('superadmin');
        $user->addClient($this->client);
        $manager->persist($user);
        $manager->flush();
    }

    /**
     * Removes the current client.
     *
     * @AfterScenario
     */
    protected function removeClient()
    {
        $this->getClientService()->remove($this->client);
    }

    /**
     * Retrieve an access token.
     */
    protected function retrieveAccessToken()
    {
        $this->getSession()->visit('/oauth/v2/token?client_id='.$this->client->getPublicId().'&client_secret='.$this->client->getSecret().'&grant_type=client_credentials');

        $response = $this->getSession()->getPage()->getContent();
        $json = json_decode($response);
        if ($json && $json->access_token) {
            $this->accessToken = $json->access_token;
        }
    }

    /**
     * @return ClientService
     */
    protected function getClientService()
    {
        return $this->get('oauth.factory.client');
    }
}
