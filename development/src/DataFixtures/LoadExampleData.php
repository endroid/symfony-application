<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Example;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadExampleData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = Yaml::parse(file_get_contents(__DIR__.'/data/examples.yaml'));

        foreach ($data['examples'] as $key => $item) {
            $example = new Example($item['id'], $item['name']);
            $this->addReference($key, $example);
            $manager->persist($example);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
