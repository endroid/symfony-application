<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Message\Query\Handler;

use App\Message\Query\DemoQuery;

class DemoQueryHandler2
{
    public function __invoke(DemoQuery $query)
    {
        dump('b');
        dump($query);
    }
}
