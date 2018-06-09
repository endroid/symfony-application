<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Message\Event\Handler;

use App\Message\Event\DemoEvent;

class DemoEventHandler
{
    public function __invoke(DemoEvent $event)
    {
        dump($event);
        die;
    }
}
