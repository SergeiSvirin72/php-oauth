<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\RefreshToken;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

class RefreshTokenRepository extends EntityRepository implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        return new RefreshToken();
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity): void
    {
        $this->_em->persist($refreshTokenEntity);
        $this->_em->flush();
    }

    public function revokeRefreshToken($tokenId): void
    {
        /** @var RefreshToken $refreshToken */
        $refreshToken = $this->find($tokenId);
        if (null !== $refreshToken) {
            $refreshToken->setIsRevoked(true);
            $this->_em->persist($refreshToken);
            $this->_em->flush();
        }
    }

    public function isRefreshTokenRevoked($tokenId): bool
    {
        /** @var RefreshToken $refreshToken */
        $refreshToken = $this->find($tokenId);

        return null === $refreshToken
            || true === $refreshToken->getIsRevoked()
            || (new DateTimeImmutable()) > $refreshToken->getExpiryDateTime();
    }
}
