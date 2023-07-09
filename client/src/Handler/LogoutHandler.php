<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\SessionManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutHandler
{
    public function __construct(private SessionManager $sessionManager)
    {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->sessionManager->remove('access_token');
        $this->sessionManager->remove('refresh_token');

        return $response;
    }
}
