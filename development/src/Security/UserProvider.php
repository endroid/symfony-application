<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
//        try {
//            return parent::loadUserByOAuthUserResponse($response);
//        } catch (AccountNotLinkedException $exception) {
//            // Do nothing: we will try to link and load by email
//        }
//
//        $userEmail = (string) $response->getEmail();
//        $user = $this->userManager->findUserByEmail($userEmail);
//
//        if (!$user instanceof UserInterface) {
//            throw new BadCredentialsException(sprintf('User with email address "%s" does not exist', $userEmail));
//        }
//
//        $this->connect($user, $response);
//
//        return $user;
    }

    public function loadUserByUsername($usernameOrEmail)
    {
        return $this->userRepository->findByUsernameOrEmail($usernameOrEmail);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        $username = $user->getUsername();

        return $this->loadUserByUsername($username);
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
