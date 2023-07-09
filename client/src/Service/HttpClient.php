<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class HttpClient
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private StreamFactoryInterface $streamFactory,
    ) {
    }

    public function request(string $url, string $method, array $body, array $headers = []): ResponseInterface
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($headers, ['Content-Type: application/json']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ('POST' === $method) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_THROW_ON_ERROR));
        }

        $error = curl_error($ch);
        if (!empty($error)) {
            throw new Exception($error);
        }

        $response = $this->createResponse(curl_getinfo($ch), curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    private function createResponse(array $info, string $output): ResponseInterface
    {
        $body = $this->streamFactory->createStream($output);

        return $this->responseFactory->createResponse()
            ->withBody($body)
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($info['http_code'] === 0 ? 400 : $info['http_code']);
    }
}
