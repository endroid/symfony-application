<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\OAuthGithubTrait;
use App\Traits\OAuthGoogleTrait;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser implements UserInterface
{
    use OAuthGoogleTrait;
    use OAuthGithubTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="user_user_group")
     */
    protected $groups;
}
