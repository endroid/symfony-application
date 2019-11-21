<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

abstract class AbstractRepository extends ServiceEntityRepository
{
    protected $className;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, $this->className);
    }

    public function nextIdentity(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function save($entity, $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
