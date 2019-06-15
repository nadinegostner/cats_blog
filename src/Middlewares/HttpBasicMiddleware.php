<?php

namespace App\Middlewares;

use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class HttpBasicMiddleware
{
    protected $user;

    public function __construct(User $user, LoggerInterface $logger)
    {
        $this->user = $user;
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        //$this->user->createUser("user1", "xyz");
        //$this->user->createUser("user2", "abc");

        if ($request->hasHeader("Authorization") &&
            preg_match("/Basic (.*)/", $request->getHeaderLine("Authorization"), $matches)) {
            $credentials = explode(":", base64_decode($matches[1]));

            // $this->logger->info(print_r($matches, true));

            if ($this->user->login($credentials[0], $credentials[1])) {
                return $next($request, $response);
            }
        }

        return $response
            ->withStatus(401)
            ->withHeader("WWW-Authenticate", 'Basic realm="Sicherer Bereich bitte einloggen!"');
    }
}