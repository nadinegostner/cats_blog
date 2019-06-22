<?php

namespace App\Middlewares;

use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use App\Helper\Session;

class WebFormMiddleware
{
    protected $user;
    protected $logger;
    protected $session;

    public function __construct(User $user, LoggerInterface $logger, Session $session)
    {
        $this->user = $user;
        $this->logger = $logger;
        $this->session = $session;

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        //$route = $request->getAttribute('route');
        /* $this->user->createUser("user1", "xyz");
        $this->user->createUser("user2", "abc"); */

        if($this->session->get("username"))
        {
            $username = $this->session->get("username");
            $password = $this->session->get("password");

            if($this->user->login($username, $password))
            {
               return $next($request, $response);
            }
            else
            {
               $this->session->killAll();
               return $response->withRedirect("/login");
            }
        }
        else if($request->getUri()->getPath()=="/register")
        {
            return $next($request, $response);
        }
        else if($request->getUri()->getPath()=="/update")
        {
            return $next($request, $response);
        }
        else if($request->getUri()->getPath()!== "/login")
        {
            return $response->withRedirect("/login");
        }
        return $next($request, $response);
    }
}