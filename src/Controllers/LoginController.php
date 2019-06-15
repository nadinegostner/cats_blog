<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Http\Response;
use App\Models\User;
use App\Helper\Session;

class LoginController
{
    protected $view;
    protected $user;
    protected $session;

    public function __construct(Twig $view, User $user, Session $session)
    {
        $this->view = $view;
        $this->user = $user;
        $this->session = $session;
    }

    public function login(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if($request->isPost() && $request->getParam('username') && $request->getParam('password')){

            $username = $request->getParam('username');
            $password = $request->getParam('password');

            if ($this->user->login($username, $password)) {
               $this->session->set("username", $username);
               $this->session->set("password", $password); 
               return $response->withRedirect("/");
            } else {
               return $this->view->render($response, 'login.twig', array("loginError" => true)); 
            }
        }

        return $this->view->render($response, 'login.twig');
    }

    public function logout(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->session->killAll();
        return $this->view->render($response, 'login.twig');
    }

    public function register(ServerRequestInterface $request, ResponseInterface $response) {
       
        if($request->isPost() && $request->getParam('username') && $request->getParam('password') && $request->getParam('passwordRepeat') && $request->getParam('firstName') && $request->getParam('lastName') && $request->getParam('email') ){

            $username = $request->getParam('username');
            $password = $request->getParam('password');
            $passwordRepeat = $request->getParam('passwordRepeat');
            $firstName = $request->getParam('firstName');
            $lastName = $request->getParam('lastName');
            $email = $request->getParam('email');

            if (!$this->user->exists($username)) {
                if($password == $passwordRepeat) {
                   $this->user->createUser($username, $password, $firstName, $lastName, $email);
                   return $response->withRedirect("/login"); 
                } else {
                    return $this->view->render($response, 'register.twig', array("loginError" => "Die angegebenen Passwörter stimmen nicht überein, versuchen Sie es erneut!")); 
                }
            } else {
               return $this->view->render($response, 'register.twig', array("loginError" => "Der Benutzername existiert bereits, bitte verwenden Sie einen anderen")); 
            }
        }
        return $this->view->render($response, 'register.twig');
    }
}