<?php

namespace App\Repository;

use Ramsey\Uuid\Uuid;

trait RepositoryOperationsTrait
{
    public function nextId(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save($entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}