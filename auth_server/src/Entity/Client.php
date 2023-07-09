<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\Creatable;
use App\Entity\Trait\Updatable;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\ClientEntityInterface;

#[HasLifecycleCallbacks]
#[Entity(repositoryClass: ClientRepository::class), Table(name: 'clients')]
class Client implements ClientEntityInterface
{
    use Creatable;
    use Updatable;

    #[Id]
    #[Column(name: 'id', type: 'string', unique: true)]
    private string $identifier;

    #[Column(type: 'string', unique: true)]
    private string $name;

    #[Column(name: 'redirect_uri', type: 'string')]
    private string $redirectUri;

    #[Column(name: 'is_confidential', type: 'boolean')]
    private bool $isConfidential = false;

    #[Column(type: 'string')]
    private string $secret;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    public function isConfidential(): bool
    {
        return $this->isConfidential;
    }

    public function setIsConfidential(bool $isConfidential): void
    {
        $this->isConfidential = $isConfidential;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }
}
