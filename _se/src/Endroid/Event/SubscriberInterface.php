<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

interface SubscriberInterface
{
    /**
     * Handles an event.
     *
     * @param Event $event
     */
    public function handle(Event $event);

    /**
     * Checks if the subscriber is subscribed to a specific event.
     *
     * @param Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event);
}
