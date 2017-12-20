<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State\Storage;

use Endroid\State\Delta;

interface StorageInterface
{
    /**
     * Saves all newly created deltas.
     *
     * @param Delta[] $deltas
     *
     * @return $this
     */
    public function save(array $deltas);

    /**
     * Loads all new deltas from the database. Make sure the deltas are
     * returned in the order they were inserted.
     *
     * @return Delta[]
     */
    public function load();

    /**
     * Marks a delta as processed. This makes sure it is processed only once.
     *
     * @param Delta $delta
     *
     * @return $this
     */
    public function markDeltaAsProcessed(Delta $delta);
}
