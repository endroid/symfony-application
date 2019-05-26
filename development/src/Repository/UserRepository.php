<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRepository extends AbstractRepository
{
    protected $className = User::class;

    private $passwordEncoder;

    public function __construct(RegistryInterface $registry, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry);

        $this->passwordEncoder = $passwordEncoder;
    }

    public function save($entity, $flush = true): void
    {
        /** @var User $entity */
        if ($entity->getPlainPassword() !== '') {
            $entity->setPassword(
                $this->passwordEncoder->encodePassword(
                    $entity,
                    $entity->getPlainPassword()
                )
            );
        }

        parent::save($entity, $flush);
    }
}
