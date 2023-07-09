<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\RouteParserInterface;

class ResponseGenerator
{
    public function __construct(private RouteParserInterface $routeParser)
    {
    }

    public function redirect(ResponseInterface $response, string $name, array $params = []): ResponseInterface
    {
        $url = $this->routeParser->urlFor($name, [], $params);

        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
