<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends EasyAdminController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function persistEntity($entity): void
    {
        $this->encodePassword($entity);
        parent::persistEntity($entity);
    }

    public function updateEntity($entity): void
    {
        $this->encodePassword($entity);
        parent::updateEntity($entity);
    }

    public function encodePassword($user): void
    {
        if (!$user instanceof User) {
            return;
        }

        $plainPassword = $user->getPlainPassword();

        if (null === $plainPassword) {
            return;
        }

        $user->setPassword($this->passwordEncoder->encodePassword($user, $plainPassword));
    }
}
