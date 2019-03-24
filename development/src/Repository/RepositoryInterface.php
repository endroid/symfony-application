<?php

declare(strict_types=1);

namespace App\Repository;

use Ramsey\Uuid\UuidInterface;

interface RepositoryInterface
{
    public function nextIdentity(): UuidInterface;
    
    public function save($entity): void;
}
