<?php

declare(strict_types=1);

namespace App\Controller\Mercure;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class StatusController
{
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @Route("/mercure/status", name="mercure_status")
     */
    public function __invoke(Request $request): Response
    {
        return new Response($this->templating->render('mercure/status.html.twig'));
    }
}
