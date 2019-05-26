<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class LoadUserData extends Fixture implements OrderedFixtureInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $data = Yaml::parse((string) file_get_contents(__DIR__.'/data/users.yaml'));

        foreach ($data['users'] as $key => $item) {
            $user = new User(
                $this->userRepository->nextIdentity(),
                $item['username'],
                $item['email']
            );
            $user->setPlainPassword($item['password']);
            $user->setRoles($item['roles']);
            $this->addReference($key, $user);
            $this->userRepository->save($user);
        }
    }

    public function getOrder(): int
    {
        return 5;
    }
}
