<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use OAuthBundle\Factory\ClientFactory;
use OAuthBundle\Model\OAuthUserInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserListener implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getEntity();

        // Only apply when correct interface is implemented
        if (!$user instanceof OAuthUserInterface) {
            return;
        }

        // Only add a client when none exist
        if (count($user->getOAuthClients()) > 0) {
            return;
        }

        $client = $this->getClientFactory()->create(['grant_types' => ['client_credentials']]);
        $user->addOAuthClient($client);
    }

    /**
     * Returns the client factory.
     *
     * @return ClientFactory
     */
    protected function getClientFactory()
    {
        return $this->container->get('oauth.factory.client');
    }
}
