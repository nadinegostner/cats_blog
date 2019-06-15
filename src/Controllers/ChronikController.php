<?php


namespace App\Controllers;

use Slim\Views\Twig;

class ChronikController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function chronik($request, $response, $args)
    {
        return $this->view->render($response, 'chronik.twig');
    }
}