<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OAuthBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OAuthBundle\Entity\Client;

trait OAuthUserTrait
{


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->oAuthClients = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function setOAuthClients($clients)
    {
        $this->oAuthClients = $clients;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasOAuthClient(Client $client)
    {
        return $this->oAuthClients->contains($client);
    }

    /**
     * {@inheritdoc}
     */
    public function removeOAuthClient(Client $client)
    {
        $this->oAuthClients->removeElement($client);
    }
}
