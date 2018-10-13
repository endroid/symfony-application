<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class LoadUserData extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('superadmin');
        $user->setPlainPassword('superadmin');
        $user->setEmail('info@endroid.nl');
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setEnabled(true);

        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder(): int
    {
        return 10;
    }
}
