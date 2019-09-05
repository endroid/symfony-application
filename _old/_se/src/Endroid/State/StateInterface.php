<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State;

interface StateInterface
{
    /**
     * Creates a new instance.
     *
     * @param $name
     */
    public function __construct($name);

    /**
     * @return string
     */
    public function getName();
}
