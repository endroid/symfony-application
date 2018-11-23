<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

class UserRepository extends AbstractRepository
{
    protected $className = User::class;
}
