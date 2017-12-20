<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

class EventPublisher
{
    /**
     * @var SubscriberInterface[]
     */
    protected $subscribers;

    /**
     * Creates a new instance.
     */
    public function __construct()
    {
        $this->subscribers = [];
    }

    /**
     * Subscribes a subscriber.
     *
     * @param SubscriberInterface $subscriber
     */
    public function subscribe(SubscriberInterface $subscriber)
    {
        $this->subscribers[spl_object_hash($subscriber)] = $subscriber;
    }

    /**
     * Unsubscribes a subscriber.
     *
     * @param SubscriberInterface $subscriber
     */
    public function unsubscribe(SubscriberInterface $subscriber)
    {
        unset($this->subscribers[spl_object_hash($subscriber)]);
    }

    /**
     * Publishes an event.
     *
     * @param Event $event
     */
    public function publish(Event $event)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }
}
