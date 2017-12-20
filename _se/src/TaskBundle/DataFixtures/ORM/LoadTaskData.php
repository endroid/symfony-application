<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TaskBundle;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Endroid\State\Manager;
use Endroid\State\UuidGenerator\UuidGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TaskBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements ContainerAwareInterface, FixtureInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        //        $stateManager = $this->getStateManager();

//        for ($n = 1; $n <= 5; ++$n) {
//            $task = new Task($this->getUuidGenerator()->generate());
//            $task->label = 'Task '.$n;
//            $stateManager->add($task);
//        }

//        $stateManager->save();
    }

    /**
     * @return Manager
     */
    protected function getStateManager()
    {
        return $this->container->get('endroid.state.manager');
    }

    /**
     * @return UuidGeneratorInterface
     */
    protected function getUuidGenerator()
    {
        return $this->container->get('endroid.state.uuid_generator');
    }
}
