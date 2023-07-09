<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AccessTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;

#[Entity(repositoryClass: AccessTokenRepository::class), Table(name: 'access_tokens')]
class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait;

    #[Id]
    #[Column(name: 'id', type: 'string', unique: true)]
    private string $identifier;

    #[Column(name: 'user_id', type: 'string')]
    private string $userIdentifier;

    #[ManyToOne(targetEntity: Client::class)]
    #[JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private ClientEntityInterface $client;

    /**
     * @var ScopeEntityInterface[]
     */
    #[Column(type: 'json')]
    private array $scopes = [];

    #[Column(name: 'expiry_date_time', type: 'datetime_immutable')]
    private DateTimeImmutable $expiryDateTime;

    #[Column(name: 'is_revoked', type: 'boolean')]
    private bool $isRevoked = false;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier($identifier): void
    {
        $this->userIdentifier = $identifier;
    }

    public function getClient(): ClientEntityInterface
    {
        return $this->client;
    }

    public function setClient(ClientEntityInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ScopeEntityInterface[]
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function addScope(ScopeEntityInterface $scope): void
    {
        $this->scopes[] = $scope;
    }

    public function getExpiryDateTime(): DateTimeImmutable
    {
        return $this->expiryDateTime;
    }

    public function setExpiryDateTime(DateTimeImmutable $dateTime): void
    {
        $this->expiryDateTime = $dateTime;
    }

    public function getIsRevoked(): bool
    {
        return $this->isRevoked;
    }

    public function setIsRevoked(bool $isRevoked): void
    {
        $this->isRevoked = $isRevoked;
    }
}
