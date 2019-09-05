<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TaskBundle\Handler;

use Endroid\Event\EventPublishingCommandHandler;
use Endroid\Task\TaskCreatedEvent;
use Ramsey\Uuid\Uuid;
use TaskBundle\Command\CreateTaskCommand;
use TaskBundle\Entity\Task;

class CreateTaskHandler extends EventPublishingCommandHandler
{
    /**
     * Handles the command.
     *
     * @param CreateTaskCommand $createTaskCommand
     */
    public function handle(CreateTaskCommand $createTaskCommand)
    {
        $task = new Task(Uuid::uuid4());
        $task->title = $createTaskCommand->title;
        $task->description = $createTaskCommand->description;
        $task->dateStart = $createTaskCommand->dateStart;
        $task->dateEnd = $createTaskCommand->dateEnd;

        $taskCreatedEvent = new TaskCreatedEvent($task);

        $this->eventPublisher->publish($taskCreatedEvent);
    }
}
