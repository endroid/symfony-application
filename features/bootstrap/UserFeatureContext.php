<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\RawMinkContext;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserFeatureContext extends RawMinkContext
{
    private $session;
    private $userManager;

    public function __construct(SessionInterface $session, UserManagerInterface $userManager)
    {
        $this->session = $session;
        $this->userManager = $userManager;
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
}
