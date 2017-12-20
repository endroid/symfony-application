<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;
use UserBundle\Entity\Group;
use UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = Yaml::parse(file_get_contents(__DIR__.'/../../Resources/fixtures/user_data.yml'));

        foreach ($data['groups'] as $id => $groupData) {
            $group = $this->createGroup($groupData);
            $manager->persist($group);
            $this->addReference($id, $group);
        }

        foreach ($data['users'] as $id => $userData) {
            $user = $this->createUser($userData);
            $manager->persist($user);
            $this->addReference($id, $user);
        }

        $manager->flush();
    }

    /**
     * Creates a group.
     *
     * @param array $groupData
     *
     * @return Group
     */
    protected function createGroup(array $groupData)
    {
        $group = new Group($groupData['name']);

        foreach ($groupData['roles'] as $role) {
            $group->addRole($role);
        }

        return $group;
    }

    /**
     * Creates a user.
     *
     * @param array $userData
     *
     * @return User
     */
    protected function createUser(array $userData)
    {
        $user = new User();
        $user->setUsername($userData['username']);
        $user->setEmail($userData['email']);
        $user->setPlainPassword($userData['password']);
        $user->setEnabled($userData['enabled']);

        foreach ($userData['groups'] as $group) {
            $group = $this->getReference($group);
            if ($group instanceof Group) {
                $user->addGroup($group);
            }
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
