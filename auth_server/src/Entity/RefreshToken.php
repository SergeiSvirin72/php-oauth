<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RefreshTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;

#[Entity(repositoryClass: RefreshTokenRepository::class), Table(name: 'refresh_tokens')]
class RefreshToken implements RefreshTokenEntityInterface
{
    #[Id]
    #[Column(name: 'id', type: 'string', unique: true)]
    private string $identifier;

    #[OneToOne(targetEntity: AccessToken::class)]
    #[JoinColumn(name: 'access_token_id', referencedColumnName: 'id')]
    private AccessTokenEntityInterface $accessToken;

    #[Column(name: 'expiry_date_time', type: 'datetime_immutable')]
    private DateTimeImmutable $expiryDateTime;

    #[Column(name: 'is_revoked', type: 'boolean')]
    private bool $isRevoked = false;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(mixed $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getAccessToken(): AccessTokenEntityInterface
    {
        return $this->accessToken;
    }

    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
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
