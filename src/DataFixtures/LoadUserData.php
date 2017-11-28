<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\OAuth\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use FOS\OAuthServerBundle\Entity\ClientManager;

class LoadUserData extends Fixture
{
    private $clientManager;

    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('superadmin');
        $user->setPlainPassword('superadmin');
        $user->setEmail('info@endroid.nl');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();

        $this->createOAuthClient($user);
    }

    private function createOAuthClient(User $user)
    {
        /** @var Client $client */
        $client = $this->clientManager->createClient();
        $client->setAllowedGrantTypes(['client_credentials']);
        $client->setUser($user);
        $this->clientManager->updateClient($client);
    }
}
