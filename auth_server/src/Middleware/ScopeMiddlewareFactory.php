<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ScopeMiddlewareFactory
{
    public function __construct(private ResponseFactoryInterface $responseFactory)
    {
    }

    public function create(array $scopes): Closure
    {
        $responseFactory = $this->responseFactory;

        return function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($responseFactory, $scopes) {
            $tokenScopes = $request->getAttribute('oauth_scopes');
            if (!empty(array_diff($scopes, $tokenScopes))) {
                return $responseFactory->createResponse(403);
            }

            return $handler->handle($request);
        };
    }
}
