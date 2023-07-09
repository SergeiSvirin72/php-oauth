<?php

declare(strict_types=1);

namespace App\Middleware;

use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ResourceServerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResourceServer $resourceServer,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $request = $this->resourceServer->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($this->responseFactory->createResponse());
        }

        return $handler->handle($request);
    }
}
