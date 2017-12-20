<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TaskBundle\Controller;

use Endroid\Command\CommandBus;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskBundle\Command\CreateTaskCommand;
use TaskBundle\Entity\Task;

class TaskController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/create")
     * @Template()
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $createTaskCommand = new CreateTaskCommand();

        $createTaskCommand->title = $request->query->get('title');
        $createTaskCommand->description = $request->query->get('description');

        $createTaskHandler = $this->get('endroid_task.create_task_handler');
        $createTaskHandler->handle($createTaskCommand);

        $findTaskQuery = new FindTaskQuery();

        return new JsonResponse([
            'task' => $task,
        ]);
    }

    /**
     * @Route("/remove", name="task_remove")
     * @Template()
     *
     * @param Request $request
     *
     * @return Response
     */
    public function removeAction(Request $request)
    {
        $uuid = $request->query->get('uuid');

        $task = $this->getDoctrine()->getManager()->getRepository('TaskBundle:Task')->findOneBy(['uuid' => $uuid]);

        $this->getDoctrine()->getManager()->remove($task);
        $this->getDoctrine()->getManager()->flush();

        $pusher = $this->getPusher();
        $pusher->trigger('tasks', 'remove', ['task' => $task]);

        return new JsonResponse([
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks.json", name="task_index")
     * @Template()
     */
    public function tasksAction()
    {
        $tasks = $this->getDoctrine()->getManager()->getRepository('TaskBundle:Task')->findAll();

        return new JsonResponse([
            'tasks' => $this->makeAssociative($tasks),
        ]);
    }

    /**
     * Makes the task array associative.
     *
     * @param Task[] $tasks
     *
     * @return Task[]
     */
    protected function makeAssociative(array $tasks)
    {
        $associativeTasks = [];
        foreach ($tasks as $task) {
            $associativeTasks[$task->getUuid()] = $task;
        }

        return $associativeTasks;
    }

    /**
     * @return CommandBus
     */
    public function getCommandBus()
    {
        return $this->get('endroid.command.command_bus');
    }
}
