<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\HttpClient;
use App\Service\SessionManager;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CallbackHandler
{
    public function __construct(
        private HttpClient $httpClient,
        private SessionManager $sessionManager,
        private string $authServerContainer,
        private string $clientId,
        private string $clientSecret,
    ) {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $state = $request->getQueryParams()['state'] ?? null;
        if (null === $state || $state !== $this->sessionManager->get('state')) {
            $this->sessionManager->remove('state');

            throw new Exception('Invalid state');
        }

        $authResponse = $this->httpClient->request($this->authServerContainer . '/access_token', 'POST', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $request->getQueryParams()['code'] ?? null,
            'code_verifier' => $this->sessionManager->get('code_verifier'),
        ]);

        $authResponseBody = json_decode($authResponse->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        if (isset($authResponseBody['access_token'], $authResponseBody['refresh_token'])) {
            $this->sessionManager->set('access_token', $authResponseBody['access_token']);
            $this->sessionManager->set('refresh_token', $authResponseBody['refresh_token']);
        }

        return $authResponse;
    }
}
