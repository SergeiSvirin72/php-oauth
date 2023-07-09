<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\SessionManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginHandler
{
    public function __construct(
        private SessionManager $sessionManager,
        private string $authServerUrl,
        private string $clientId,
    ) {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $state = 'f4d409405dfede471f2cce97f94299d6';
        $codeVerifier = 'f1fc85da736fb6b59e949769fdcef13b92ca8351b57d';
        $this->sessionManager->set('state', $state);
        $this->sessionManager->set('code_verifier', $codeVerifier);

        $queryParams = http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'scope' => 'user:main user:additional',
            'state' => $state,
            'code_challenge' => strtr(rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='), '+/', '-_'),
            'code_challenge_method' => 'S256',
        ]);
        $uri = $this->authServerUrl . '/authorize?' . $queryParams;

        return $response->withHeader('Location', $uri)->withStatus(302);
    }
}
