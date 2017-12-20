<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Event;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;

class DoctrineStore implements StoreInterface
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * Creates a new instance.
     *
     * @param EntityManager $manager
     * @param Serializer    $serializer
     */
    public function __construct(EntityManager $manager, Serializer $serializer)
    {
        $this->manager = $manager;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function append(Event $event)
    {
        $storedEvent = new StoredEvent(
            get_class($event),
            $event->occurredOn,
            $this->serializer->serialize($event, 'json')
        );

        $this->manager->persist($storedEvent);
    }
}
