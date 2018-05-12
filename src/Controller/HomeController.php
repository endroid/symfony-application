<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Twig\Environment;

class HomeController
{
    private $session;
    private $templating;

    public function __construct(SessionInterface $session, Environment $templating)
    {
        $this->session = $session;
        $this->templating = $templating;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke(Request $request): Response
    {
        return new Response($this->templating->render('home.html.twig'));
    }
}
