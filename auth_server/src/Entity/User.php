<?php

namespace App\Entity;

use App\Entity\Trait\Creatable;
use App\Entity\Trait\Updatable;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\ArrayShape;
use League\OAuth2\Server\Entities\UserEntityInterface;

#[HasLifecycleCallbacks]
#[Entity(repositoryClass: UserRepository::class), Table(name: 'users')]
class User implements UserEntityInterface
{
    use Creatable;
    use Updatable;

    #[Id]
    #[Column(name: 'id', type: 'string', unique: true)]
    private string $identifier;

    #[Column(type: 'string', unique: true)]
    private string $email;

    #[Column(type: 'string')]
    private string $password;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    #[ArrayShape(['id' => "string", 'email' => "string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->identifier,
            'email' => $this->email,
        ];
    }
}
