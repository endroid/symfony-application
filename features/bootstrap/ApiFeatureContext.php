<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Behat\Behat\Context\Context;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class ApiFeatureContext implements Context
{
    private $kernel;
    private $userManager;
    private $accessToken;
    private $response;

    public function __construct(KernelInterface $kernel, UserManagerInterface $userManager)
    {
        $this->kernel = $kernel;
        $this->userManager = $userManager;
    }

    /**
     * @Given I retrieve a JWT token with username :username and password :password
     */
    public function iRetrieveAJwtTokenFor(string $username, string $password): void
    {
        $response = $this->kernel->handle(Request::create('/api/login_check', 'POST', [
            '_username' => $username,
            '_password' => $password
        ]));

        $json = json_decode($response->getContent());

        if (!$json || !$json->token) {
            throw new \Exception('No valid token returned');
        }

        $this->accessToken = $json->token;
    }

    /**
     * @Given I use an invalid access token
     */
    public function iUseAnInvalidAccessToken(): void
    {
        $this->accessToken = 'invalid_access_token';
    }

    /**
     * @Given I perform a search call
     */
    public function iPerformASearchCall(): void
    {
        $query = 'search_query';

        $request = Request::create('/api/search', 'GET', ['query' => $query]);
        $request->headers->set('Authorization', 'Bearer '.$this->accessToken);
        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Then I should see the search results
     */
    public function iShouldSeeTheSearchResults(): void
    {
        $json = json_decode($this->response->getContent());

        if (!$json || !$json->query || !is_array($json->results)) {
            throw new \Exception('No valid response returned');
        }
    }

    /**
     * @Then I should see an error message
     */
    public function iShouldNotSeeAnErrorMessage(): void
    {
        $content = $this->response->getContent();
        $json = json_decode($content);

        if (!$json) {
            throw new \Exception('No valid response returned');
        }

        $isErrorMessage = stripos($content, 'invalid') !== false;

        if (!$isErrorMessage) {
            throw new \Exception('Response does not contain an error message');
        }
    }
}
