<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController
{
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke(): Response
    {
        return new Response($this->templating->render('home.html.twig'));
    }
}
