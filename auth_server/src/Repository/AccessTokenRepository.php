<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AccessToken;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class AccessTokenRepository extends EntityRepository implements AccessTokenRepositoryInterface
{
    public function getNewToken(
        ClientEntityInterface $clientEntity,
        array $scopes,
        $userIdentifier = null
    ): AccessTokenEntityInterface {
        $accessToken = new AccessToken();
        $accessToken->setClient($clientEntity);
        $accessToken->setUserIdentifier($userIdentifier);

        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }

        return  $accessToken;
    }

    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity): void
    {
        $this->_em->persist($accessTokenEntity);
        $this->_em->flush();
    }

    public function revokeAccessToken($tokenId): void
    {
        /** @var AccessToken $accessToken */
        $accessToken = $this->find($tokenId);
        if (null !== $accessToken) {
            $accessToken->setIsRevoked(true);
            $this->_em->persist($accessToken);
            $this->_em->flush();
        }
    }

    public function isAccessTokenRevoked($tokenId): bool
    {
        /** @var AccessToken $accessToken */
        $accessToken = $this->find($tokenId);

        return null === $accessToken
            || true === $accessToken->getIsRevoked()
            || (new DateTimeImmutable()) > $accessToken->getExpiryDateTime();
    }
}
