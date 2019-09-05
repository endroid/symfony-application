<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TaskBundle\Controller;

use Endroid\Command\CommandBus;
use Endroid\Task\Command\FindTasks;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskApiController extends FOSRestController
{
    /**
     * Lists all tasks.
     *
     * @ApiDoc(
     *   section="Task",
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when unauthorized"
     *   }
     * )
     *
     * @Security("has_role('ROLE_API')")
     *
     * @Annotations\View(statusCode=200)
     *
     * @return Response
     */
    public function getTasksAction()
    {
        $findTasks = new FindTasks();
        $findTasks->offset = 0;
        $findTasks->limit = 5;

        $tasks = $this->getCommandBus()->execute($findTasks);

        return new JsonResponse($tasks);
    }

    /**
     * Returns the command bus.
     *
     * @return CommandBus
     */
    protected function getCommandBus()
    {
        return $this->get('endroid_command.command_bus');
    }
}
