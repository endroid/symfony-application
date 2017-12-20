<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Factory;

use Exception;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use OAuthBundle\Entity\Client;

class ClientFactory
{
    /**
     * @var ClientManagerInterface
     */
    protected $clientManager;

    /**
     * @param $clientManager
     */
    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * Creates a client.
     *
     * @param array $options
     *
     * @return Client
     *
     * @throws Exception
     */
    public function create(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $options = $optionsResolver->resolve($options);

        /** @var Client $client */
        $client = $this->clientManager->createClient();
        $client->setAllowedGrantTypes($options['grant_types']);
        $client->setRedirectUris($options['redirect_uris']);
        $client->setName('New application');

        $this->clientManager->updateClient($client);

        if (!$client->getPublicId() || !$client->getSecret()) {
            throw new Exception('Could not create valid client');
        }

        return $client;
    }

    /**
     * Configures options.
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'grant_types' => ['client_credentials'],
            'redirect_uris' => [],
            'user' => null,
        ]);
    }

    /**
     * Removes a client.
     *
     * @param Client $client
     */
    public function remove(Client $client)
    {
        $this->clientManager->deleteClient($client);
    }
}
