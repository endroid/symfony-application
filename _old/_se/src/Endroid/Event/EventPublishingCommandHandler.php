<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

class EventPublishingCommandHandler
{
    /**
     * @var EventPublisher
     */
    public $eventPublisher;

    /**
     * Creates a new instance.
     *
     * @param EventPublisher $eventPublisher
     */
    public function __construct(EventPublisher $eventPublisher)
    {
        $this->eventPublisher = $eventPublisher;
    }
}
