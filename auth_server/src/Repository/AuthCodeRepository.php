<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AuthCode;
use App\Entity\Client;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository extends EntityRepository implements AuthCodeRepositoryInterface
{
    public function getNewAuthCode(): AuthCodeEntityInterface
    {
        return new AuthCode();
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {
        // После десериализации объект Client становится detached, поэтому еще раз достаем из БД
        $client = $this->_em->find(Client::class, $authCodeEntity->getClient()->getIdentifier());
        $authCodeEntity->setClient($client);
        $this->_em->persist($authCodeEntity);
        $this->_em->flush();
    }

    public function revokeAuthCode($codeId): void
    {
        /** @var AuthCode $authCode */
        $authCode = $this->find($codeId);
        if (null !== $authCode) {
            $authCode->setIsRevoked(true);
            $this->_em->persist($authCode);
            $this->_em->flush();
        }
    }

    public function isAuthCodeRevoked($codeId): bool
    {
        /** @var AuthCode $authCode */
        $authCode = $this->find($codeId);

        return null === $authCode
            || true === $authCode->getIsRevoked()
            || (new DateTimeImmutable()) > $authCode->getExpiryDateTime();
    }
}
