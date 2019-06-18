<?php


namespace App\Controllers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Models\User;


class ProfilController
{
    protected $view;
    protected $user;

    public function __construct(Twig $view, User $user)
    {
        $this->view = $view;
        $this->user = $user;
    }

    public function profil(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $userprofile = $this->user->userAnzeigen();

        return $this->view->render($response, 'profil.twig',
            [
                'userid' => $userprofile->id,
                'username' => $userprofile->username,
                'firstname' => $userprofile->first_name,
                'lastname' => $userprofile->last_name,
                'email' => $userprofile->email
        ]);
    }



}