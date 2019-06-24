<?php


namespace App\Controllers;

use App\Models\Chronik;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DashboardController
{
    protected $view;
    protected $chronik;

    public function __construct(Twig $view, Chronik $chronik)
    {
        $this->view = $view;
        $this->chronik = $chronik;
    }

    public function dashboard(ServerRequestInterface $request, ResponseInterface $response)
    {
        $cats = $this->chronik->anzeigeneigene();

        return $this->view->render($response, 'dashboard.twig',
            [
            'cats' => $cats,
        ]);
    }

    public function editpostpage(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getParam('id');
        $cats = $this->chronik->editanzeigen($id);

        return $this->view->render($response, 'editPost.twig',
            [
                'cats' => $cats,
            ]);


    }

}