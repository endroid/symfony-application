<?php

namespace App\DataFixtures;

use App\Entity\Example;
use App\Message\Example\CreateExample;
use App\Message\Example\GetExample;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Yaml\Yaml;

class LoadExampleData extends Fixture implements OrderedFixtureInterface
{
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function load(ObjectManager $manager): void
    {
        $data = Yaml::parse(file_get_contents(__DIR__.'/data/examples.yaml'));

        foreach ($data['examples'] as $key => $item) {
            $createExample = new CreateExample($item['id'], $item['name']);
            $this->messageBus->dispatch($createExample);
            $getExample = new GetExample($item['id']);
            $example = $this->messageBus->dispatch($getExample);
            $this->addReference($key, $example);
        }
    }

    public function getOrder(): int
    {
        return 5;
    }
}
