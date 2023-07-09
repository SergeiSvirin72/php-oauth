<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\HttpClient;
use App\Service\SessionManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ResourceHandler
{
    public function __construct(
        private HttpClient $httpClient,
        private SessionManager $sessionManager,
        private string $authServerContainer,
    ) {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->httpClient->request($this->authServerContainer . '/resource', 'GET', [], [
            'Authorization:Bearer ' . $this->sessionManager->get('access_token'),
        ]);
    }
}
