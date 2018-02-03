<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    public function getSuggest(): array
    {
        return [
            'input' => [
                $this->getUsername(),
                $this->getEmail()
            ],
            'weight' => $this->hasRole('ROLE_SUPER_ADMIN') ? 1 : 0,
        ];
    }
}
