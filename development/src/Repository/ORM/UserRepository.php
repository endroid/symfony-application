<?php

declare(strict_types=1);

namespace App\Repository\ORM;

use App\Entity\User;

class UserRepository extends AbstractRepository
{
    protected $className = User::class;
}
