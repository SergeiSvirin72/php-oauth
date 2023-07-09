<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\UserRepository;
use App\Service\ResponseGenerator;
use App\Service\SessionManager;
use App\Validator\LoginValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Views\PhpRenderer;

class LoginHandler
{
    public function __construct(
        private LoginValidator $loginValidator,
        private PhpRenderer $renderer,
        private SessionManager $sessionManager,
        private UserRepository $userRepository,
        private RouteParserInterface $routeParser,
        private ResponseGenerator $responseGenerator,
    ) {
    }

    public function handle(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        if (!isset($body['submit'])) {
            return $this->render($response, $request);
        }

        $error = $this->loginValidator->validate($body);
        if (null !== $error) {
            $this->sessionManager->set('error', $error);

            return $this->render($response, $request);
        }

        $user = $this->userRepository->findByCredentials($body['email'], $body['password']);
        if (null === $user) {
            $this->sessionManager->set('error', 'Invalid login or password');

            return $this->render($response, $request);
        }

        $this->sessionManager->set('user_id', $user->getIdentifier());

        $queryParams = $request->getQueryParams();
        if (isset($queryParams['return_to_authorize'])) {
            return $this->responseGenerator->redirect($response, 'authorize', [
                'client_id' => $queryParams['client_id'] ?? null
            ]);
        }

        return $this->responseGenerator->redirect($response, 'profile');
    }

    private function render(ResponseInterface $response, ServerRequestInterface $request): ResponseInterface
    {
        return $this->renderer->render($response, 'login.php', [
            'url' => $this->routeParser->urlFor('login') . '?' . $request->getUri()->getQuery(),
            'error' => $this->sessionManager->flash('error'),
        ]);
    }
}
