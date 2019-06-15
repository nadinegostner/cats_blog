<?php


namespace App\Controllers;


use Slim\Views\Twig;

class NewsletterController
{
    protected $view;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function newsletter($request, $response, $args)
    {
        return $this->view->render($response, 'newsletter.twig');
    }
}