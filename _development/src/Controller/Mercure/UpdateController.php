<?php

declare(strict_types=1);

namespace App\Controller\Mercure;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class UpdateController
{
    private $commandBus;
    private $templating;

    public function __construct(MessageBusInterface $commandBus, Environment $templating)
    {
        $this->commandBus = $commandBus;
        $this->templating = $templating;
    }

    /**
     * @Route("/mercure/update", name="mercure_update")
     */
    public function __invoke(Request $request): Response
    {
        $update = new Update(
            'http://localhost/update',
            (string) json_encode(['status' => $request->query->get('status', 'none')])
        );

        $this->commandBus->dispatch($update);

        return new Response('Update sent');
    }
}
