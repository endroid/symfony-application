<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class AppController
{
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    public function __invoke(): Response
    {
        return new Response($this->templating->render('app.html.twig'));
    }
}
