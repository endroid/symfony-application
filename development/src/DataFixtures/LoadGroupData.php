<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadGroupData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = Yaml::parse((string) file_get_contents(__DIR__.'/data/user_groups.yaml'));

        foreach ($data['user_groups'] as $key => $item) {
            $group = new Group($item['name'], $item['roles']);
            $this->addReference($key, $group);
            $manager->persist($group);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 5;
    }
}
