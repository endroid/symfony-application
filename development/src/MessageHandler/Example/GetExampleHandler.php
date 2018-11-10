<?php

namespace App\MessageHandler\Example;

use App\Message\Example\GetExample;
use App\Repository\ExampleRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetExampleHandler implements MessageHandlerInterface
{
    private $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function __invoke(GetExample $getExample)
    {
        $example = $this->exampleRepository->findOneBy(['id' => $getExample->getId()]);

        return $example;
    }
}
