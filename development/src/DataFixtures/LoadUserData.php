<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Yaml\Yaml;

class LoadUserData extends Fixture implements OrderedFixtureInterface
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager): void
    {
        $data = Yaml::parse(file_get_contents(__DIR__.'/data/users.yaml'));

        foreach ($data['users'] as $key => $item) {
            $user = $this->userManager->createUser();
            $user->setUsername($item['username']);
            $user->setPlainPassword($item['password']);
            $user->setEmail($item['email']);
            $user->setEnabled(true);

            foreach ($item['groups'] as $groupKey) {
                $user->addGroup($this->getReference($groupKey));
            }

            $this->addReference($key, $user);
            $this->userManager->updateUser($user);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 10;
    }
}
