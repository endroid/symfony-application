<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State;

use Endroid\State\Storage\StorageInterface;

class StateObserver
{
    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * Creates a new instance.
     *
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Runs the monitor.
     *
     * @param bool $loop
     */
    public function monitor($loop = false)
    {
        $deltas = $this->storage->load();

        foreach ($deltas as $delta) {
            dump($delta);
            $this->storage->markDeltaAsProcessed($delta);
        }

        if ($loop) {
            sleep(1);
            $this->monitor(true);
        }
    }
}
