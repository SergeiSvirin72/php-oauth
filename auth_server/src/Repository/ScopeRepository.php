<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Scope;
use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository extends EntityRepository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier): ?Scope
    {
        return $this->find($identifier);
    }

    public function finalizeScopes(array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null): array
    {
        return $scopes;
    }
}
