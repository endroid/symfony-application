<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

use DateTime;

class StoredEvent
{
    /**
     * @var string
     */
    public $className;

    /**
     * @var
     */
    public $serialized;

    /**
     * @var DateTime
     */
    public $occurredOn;

    /**
     * Creates a new instance.
     *
     * @param $className
     * @param $occurredOn
     * @param $serializedEvent
     */
    public function __construct($className, $occurredOn, $serializedEvent)
    {
        $this->className = $className;
        $this->occurredOn = $occurredOn;
        $this->serializedEvent = $serializedEvent;
    }
}
