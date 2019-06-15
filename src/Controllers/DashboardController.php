<?php


namespace App\Controllers;

use Slim\Views\Twig;

class DashboardController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function dashboard($request, $response, $args)
    {
        return $this->view->render($response, 'dashboard.twig');
    }

}