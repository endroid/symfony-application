<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
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
        $this->session->getFlashBag()->add('info', 'Welcome!');

        return new Response($this->templating->render('home.html.twig'));
    }
}
