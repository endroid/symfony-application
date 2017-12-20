<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

class PersistSubscriber implements SubscriberInterface
{
    /**
     * @var StoreInterface
     */
    protected $store;

    /**
     * Creates a new instance.
     *
     * @param StoreInterface $store
     */
    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $pusher = $this->getPusher();
        $pusher->trigger('tasks', 'create', ['task' => $task]);

        $this->store->append($event);
    }

    /**
     * {@inheritdoc}
     */
    public function isSubscribedTo(Event $event)
    {
        return true;
    }
}
