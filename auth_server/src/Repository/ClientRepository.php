<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

class ClientRepository extends EntityRepository implements ClientRepositoryInterface
{
    public function getClientEntity($clientIdentifier): ?ClientEntityInterface
    {
        return $this->find($clientIdentifier);
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        $client = $this->getClientEntity($clientIdentifier);

        if (null === $client || $client->getSecret() !== $clientSecret) {
            return false;
        }

        return true;
    }
}
