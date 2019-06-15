<?php


namespace App\Controllers;


use Slim\Views\Twig;

class ProfilController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function profil($request, $response, $args)
    {
        return $this->view->render($response, 'profil.twig');
    }

}