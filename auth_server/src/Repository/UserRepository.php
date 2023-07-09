<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findById(string $id): ?User
    {
        return $this->find($id);
    }

    public function findByCredentials(string $email, string $password): ?User
    {
        $user = $this->findOneBy(['email' => $email]);
        if (null === $user || !password_verify($password, $user->getPassword())) {
            return null;
        }

        return $user;
    }
}
