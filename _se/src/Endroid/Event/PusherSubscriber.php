<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

use Pusher;

class PusherSubscriber implements SubscriberInterface
{
    /**
     * @var Pusher
     */
    protected $pusher;

    /**
     * Creates a new instance.
     *
     * @param Pusher $pusher
     */
    public function __construct(Pusher $pusher)
    {
        $this->pusher = $pusher;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        dump($event);
        die('pusher subscriber dump');

        //        $this->pusher->trigger('tasks', 'create', ['task' => $task]);
    }

    /**
     * {@inheritdoc}
     */
    public function isSubscribedTo(Event $event)
    {
        return true;
    }
}
