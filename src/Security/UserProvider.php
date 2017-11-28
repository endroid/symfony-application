<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Security;

use FOS\UserBundle\Model\UserInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class UserProvider extends FOSUBUserProvider
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch (AccountNotLinkedException $exception) {
            // Do nothing: we will try to link and load by email
        }

        $userEmail = $response->getEmail();
        $user = $this->userManager->findUserByEmail($userEmail);

        if (!$user instanceof UserInterface) {
            throw new BadCredentialsException(sprintf('User with email address "%s" does not exist', $userEmail));
        }

        $this->connect($user, $response);

        return $user;
    }
}
