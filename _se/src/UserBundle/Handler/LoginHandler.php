<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var AuthorizationChecker
     */
    protected $authorizationChecker;

    /**
     * @var Router
     */
    protected $router;

    /**
     * Creates a new instance.
     *
     * @param AuthorizationChecker $authorizationChecker
     * @param Router               $router
     */
    public function __construct(AuthorizationChecker $authorizationChecker, Router $router)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $target = 'app_home_index';

        if ($this->authorizationChecker->isGranted('ROLE_API')) {
            $target = 'nelmio_api_doc_index';
        }

        if ($this->authorizationChecker->isGranted('ROLE_INTAKE')) {
            $target = 'endroid_intake_intake_index';
        }

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $target = 'sonata_admin_dashboard';
        }

        return new RedirectResponse($this->router->generate($target));
    }
}
