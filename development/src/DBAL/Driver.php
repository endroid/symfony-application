<?php

declare(strict_types=1);

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
