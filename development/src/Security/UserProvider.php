<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider extends FOSUBUserProvider
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return self::loadUserByOAuthUserResponse($response);
        } catch (AccountNotLinkedException $exception) {
            // Do nothing: we will try to link and load by email
        }

        $userEmail = (string) $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        if (!$user instanceof UserInterface) {
            throw new BadCredentialsException(sprintf('User with email address "%s" does not exist', $userEmail));
        }

        $this->connect($user, $response);

        return $user;
    }
}
