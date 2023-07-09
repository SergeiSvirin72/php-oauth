<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Client;
use App\Entity\Scope;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\SessionManager;
use App\Service\ResponseGenerator;
use DateTime;
use Exception;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\PhpRenderer;

class AuthorizeHandler
{
    public function __construct(
        private AuthorizationServer $authorizationServer,
        private SessionManager $sessionManager,
        private UserRepository $userRepository,
        private PhpRenderer $renderer,
        private RouteParserInterface $routeParser,
        private ResponseGenerator $responseGenerator,
    ) {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $clientId = $request->getQueryParams()['client_id'] ?? null;

        try {
            $authRequestString = $this->sessionManager->get($this->getAuthRequestKey($clientId));
            if (null !== $authRequestString) {
                $authRequest = $this->deserializeAuthRequest($authRequestString);
            } else {
                $authRequest = $this->authorizationServer->validateAuthorizationRequest($request);
                $this->sessionManager->set($this->getAuthRequestKey($clientId), serialize($authRequest));
            }

            $userId = $this->sessionManager->get('user_id');
            if (null === $userId) {
                return $this->responseGenerator->redirect($response, 'login', [
                    'return_to_authorize' => true,
                    'client_id' => $clientId,
                ]);
            }

            $user = $this->userRepository->findById($userId);
            if (null === $user) {
                $this->sessionManager->remove('user_id');

                throw new Exception('User from session not found');
            }

            $submit = $request->getParsedBody()['submit'] ?? null;
            if (null === $submit) {
                return $this->render($response, $authRequest, $user, $clientId);
            }

            $this->sessionManager->remove($this->getAuthRequestKey($clientId));
            $authRequest->setUser($user);
            $authRequest->setAuthorizationApproved((bool) $submit);

            return $this->authorizationServer->completeAuthorizationRequest($authRequest, $response);
        } catch (OAuthServerException $exception) {
            $this->sessionManager->remove($this->getAuthRequestKey($clientId));

            return $exception->generateHttpResponse($response);
        }
    }

    private function deserializeAuthRequest(string $authRequest): AuthorizationRequest
    {
        return unserialize($authRequest, [
            'allowed_classes' => [
                AuthorizationRequest::class,
                Client::class,
                Scope::class,
                DateTime::class,
            ]
        ]);
    }

    private function getAuthRequestKey(string $clientId): string
    {
        return 'auth_request_' . $clientId;
    }

    private function render(
        ResponseInterface $response,
        AuthorizationRequest $authRequest,
        User $user,
        string $clientId,
    ): ResponseInterface {
        return $this->renderer->render($response, 'authorize.php', [
            'client' => $authRequest->getClient()->getName(),
            'email' => $user->getEmail(),
            'scopes' => $authRequest->getScopes(),
            'url' => $this->routeParser->urlFor('authorize', [], [
                'client_id' => $clientId,
            ])
        ]);
    }
}
