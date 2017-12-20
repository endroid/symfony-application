<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Model;

use OAuthBundle\Entity\Client;

interface OAuthUserInterface
{
    /**
     * Sets the clients.
     *
     * @param $clients
     *
     * @return $this
     */
    public function setOAuthClients($clients);

    /**
     * Checks if the user has a specific OAuth client.
     *
     * @param Client $client
     *
     * @return bool
     */
    public function hasOAuthClient(Client $client);

    /**
     * Adds an OAuth client.
     *
     * @param Client $client
     *
     * @return $this
     */
    public function addOAuthClient(Client $client);

    /**
     * Removes an OAuth client.
     *
     * @param Client $client
     *
     * @return $this
     */
    public function removeOAuthClient(Client $client);

    /**
     * Returns all OAuth clients.
     *
     * @return Client[]
     */
    public function getOAuthClients();
}
