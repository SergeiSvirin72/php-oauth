<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\UserRepository;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ResourceHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $request->getAttribute('oauth_user_id');
        if (null === $userId) {
            throw new Exception('User is not set in access token');
        }

        $user = $this->userRepository->findById($userId);
        if (null === $user) {
            throw new Exception('User not found');
        }

        $response->getBody()->write(json_encode($user->serialize(), JSON_THROW_ON_ERROR));

        return $response;
    }
}
