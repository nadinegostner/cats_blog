<?php


namespace App\Controllers;

use App\Models\Chronik;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Http\Response;
use App\Models\User;
use App\Helper\Session;

class ChronikController
{
    protected $view;
    protected $chronik;



    public function __construct(Twig $view, Chronik $chronik)
    {
        $this->view = $view;
        $this->chronik = $chronik;
    }

    public function chronik(ServerRequestInterface $request, ResponseInterface $response)
    {

        $cats = $this->chronik->anzeigenalle();

        return $this->view->render($response, 'chronik.html.twig',
            [
            'cats' => $cats
            ]);
    }

    public function postErstellen(ServerRequestInterface $request, ResponseInterface $response)
    {
        $files = $request->getUploadedFiles();
        $text =  $request->getParam('text');
        $currentUser = $_SESSION['username'];

        if ($files && isset($files['image'])) {
            $file = $files['image'];

            if ($file->getError() === UPLOAD_ERR_OK)
            {
                $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $filename = "images/" . $this->chronik->generateToken($file->getClientFilename()) . "." . $extension;
                $file->moveTo(__DIR__ . "/../../public/" . $filename);

                $this->chronik->posten($filename, $text, $currentUser);
            }
        }

        $cats = $this->chronik->anzeigenalle();

        return $this->view->render($response, 'chronik.html.twig',
        [
            'cats' => $cats
        ]);
    }

    public function postLoeschen(ServerRequestInterface $request, ResponseInterface $response)
    {

    }

    public function postAnzeigen(ServerRequestInterface $request, ResponseInterface $response)
    {
        $post = new Chronik();

        foreach($post->alleanzeigen() as $cats )
        {
            return $this->view->render($response, 'chronik.html.twig', [
               'image' => $cats->file,
                'text' => $cats->text,
                'posts' => $cats,
                'post' => $cats
            ]);
        }
    }


}