<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TaskBundle\Factory;

use Endroid\State\UuidGenerator\UuidGeneratorInterface;
use TaskBundle\Entity\Task;

class TaskFactory
{
    /**
     * @var UuidGeneratorInterface
     */
    protected $uuidGenerator;

    /**
     * Creates a new instance.
     *
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * Creates a new task.
     *
     * @param string $label
     *
     * @return Task
     */
    public function create($label)
    {
        $task = new Task($this->uuidGenerator->generate());
        $task->label = $label;

        return $task;
    }
}
