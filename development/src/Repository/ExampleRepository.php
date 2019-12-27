<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Example;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ExampleRepository extends ServiceEntityRepository
{
    use RepositoryOperationsTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Example::class);
    }
}
