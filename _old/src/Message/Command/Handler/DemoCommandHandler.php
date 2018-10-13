<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Message\Command\Handler;

use App\Message\Command\DemoCommand;

class DemoCommandHandler
{
    public function __invoke(DemoCommand $command)
    {
        dump($command);
        die;
    }
}
