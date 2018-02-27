<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Behat\Behat\Hook\Scope\AfterStepScope;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class FeatureContext extends RawMinkContext
{
    private $session;
    private $userManager;

    public function __construct(SessionInterface $session, UserManagerInterface $userManager)
    {
        $this->session = $session;
        $this->userManager = $userManager;
    }

    /**
     * @BeforeScenario
     */
    public function loadFixtures()
    {
        $command = __DIR__.'/../../bin/console" doctrine:fixtures:load --env=test -n -q';

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * @Given I am logged in as :email
     */
    public function iAmLoggedInAs(string $email): void
    {
        $firewallContext = 'main';
        $sessionName = '_security_'.$firewallContext;

        if (!$user = $this->userManager->findUserBy(['email' => $email])) {
            throw new \Exception('User ' .$email.' cannot be found');
        }

        $token = new UsernamePasswordToken($user, null, $firewallContext, $user->getRoles());

        $this->session->set($sessionName, serialize($token));
        $this->session->save();

        $driver = $this->getSession()->getDriver();
        if ($driver instanceof BrowserKitDriver) {
            $client = $driver->getClient();
            $cookie = new Cookie($this->session->getName(), $this->session->getId());
            $client->getCookieJar()->set($cookie);
        } elseif ($driver instanceof Selenium2Driver) {
            $this->visitPath('/');
            $this->getSession()->setCookie(
                $this->session->getName(),
                $this->session->getId()
            );
        } else {
            throw new \Exception('Unsupported Driver');
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
    public function iMakeAScreenshot($title = 'screenshot'): void
    {
        if (!$this->getSession()->getDriver() instanceof Selenium2Driver) {
            return;
        }

        $imageData = $this->getSession()->getScreenshot();

        file_put_contents(__DIR__.'/../screenshots/'.date('U').'-'.$subTitle.'.png', $imageData);
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
