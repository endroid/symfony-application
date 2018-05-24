<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\DBAL;

use Doctrine\DBAL\Driver\PDOMySql\Driver as BaseDriver;

class Driver extends BaseDriver
{
    public function createDatabasePlatformForVersion($version)
    {
        return $this->getDatabasePlatform();
    }

    public function getDatabasePlatform()
    {
        return new Platform();
    }
}
