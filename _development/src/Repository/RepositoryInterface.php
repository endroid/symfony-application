<?php

declare(strict_types=1);

namespace App\Repository;

interface RepositoryInterface
{
    public function nextIdentity(): string;

    public function save($entity): void;
}
