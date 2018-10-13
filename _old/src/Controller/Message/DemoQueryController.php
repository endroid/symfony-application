<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller\Message;

use App\Message\Query\DemoQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class DemoQueryController
{
    private $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @Route("/message/demo-query", name="message_demo_query")
     */
    public function __invoke(): Response
    {
        $this->queryBus->dispatch(new DemoQuery());

        return new Response();
    }
}
