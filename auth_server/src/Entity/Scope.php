<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ScopeRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

#[Entity(repositoryClass: ScopeRepository::class), Table(name: 'scopes')]
class Scope implements ScopeEntityInterface
{
    use ScopeTrait;

    #[Id]
    #[Column(name: 'id', type: 'string', unique: true)]
    private string $identifier;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }
}
