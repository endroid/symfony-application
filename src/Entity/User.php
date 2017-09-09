<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected $googleId;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected $githubId;

    /**
     * @return string
     */
    public function getGoogleId(): string
    {
        return $this->googleId;
    }

    /**
     * @param string $googleId
     * @return User
     */
    public function setGoogleId(string $googleId): User
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGithubId(): string
    {
        return $this->githubId;
    }

    /**
     * @param string $githubId
     * @return User
     */
    public function setGithubId(string $githubId): User
    {
        $this->githubId = $githubId;

        return $this;
    }
}
