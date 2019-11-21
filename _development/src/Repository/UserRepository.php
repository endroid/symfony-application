<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserRepository extends AbstractRepository
{
    protected $className = User::class;

    private $encoderFactory;

    public function __construct(RegistryInterface $registry, EncoderFactoryInterface $encoderFactory)
    {
        parent::__construct($registry);

        $this->encoderFactory = $encoderFactory;
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :query OR u.email = :query')
            ->setParameter('query', $usernameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function save($entity, $flush = true): void
    {
        /** @var User $entity */
        if ('' !== $entity->getPlainPassword()) {
            $entity->setPassword(
                $this->encoderFactory->getEncoder($entity)->encodePassword(
                    $entity->getPlainPassword(),
                    $entity->getSalt()
                )
            );
            $entity->setPlainPassword('');
        }

        parent::save($entity, $flush);
    }
}
