<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behatch\Context\RestContext;
use FOS\UserBundle\Model\UserManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;

class JwtFeatureContext implements Context
{
    private $restContext;
    private $userManager;
    private $tokenManager;

    public function __construct(UserManagerInterface $userManager, JWTManager $tokenManager)
    {
        $this->userManager = $userManager;
        $this->tokenManager = $tokenManager;
    }

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
    }

    /**
     * @Given I retrieve a JWT token for user :username
     */
    public function iRetrieveAJwtTokenForUser(string $username): void
    {
        $user = $this->userManager->findUserByUsername($username);
        $token = $this->tokenManager->create($user);
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }

    /**
     * @Given I use JWT token :token
     */
    public function iUseJwtToken(string $token): void
    {
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }
}
