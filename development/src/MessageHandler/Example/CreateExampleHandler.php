<?php

namespace App\MessageHandler\Example;

use App\Entity\Example;
use App\Message\Example\CreateExample;
use App\Repository\ExampleRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateExampleHandler implements MessageHandlerInterface
{
    private $exampleRepository;

    public function __construct(ExampleRepository $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function __invoke(CreateExample $createExample)
    {
        $example = Example::createFromMessage($createExample);
        $this->exampleRepository->save($example);
    }
}
