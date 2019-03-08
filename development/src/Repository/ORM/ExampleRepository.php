<?php

declare(strict_types=1);

namespace App\Repository\ORM;

use App\Entity\Example;
use App\Repository\ExampleRepositoryInterface;

class ExampleRepository extends AbstractRepository implements ExampleRepositoryInterface
{
    protected $className = Example::class;
}
