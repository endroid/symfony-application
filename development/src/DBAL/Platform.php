<?php

declare(strict_types=1);

namespace App\DBAL;

use Doctrine\DBAL\Platforms\MySqlPlatform;

class Platform extends MySqlPlatform
{
    public function getTruncateTableSQL($tableName, $cascade = false)
    {
        return sprintf('SET foreign_key_checks = 0;TRUNCATE %s;SET foreign_key_checks = 1;', $tableName);
    }
}
