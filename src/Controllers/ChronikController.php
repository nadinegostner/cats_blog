<?php


namespace App\Controllers;

use App\Models\Chronik;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;


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
        $currentuserid = $_SESSION['id'];
        $err_message = null;

        if ($files && isset($files['image'])) {
            $file = $files['image'];

            if (($file->getError()) === UPLOAD_ERR_OK)
            {
                $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $filename = "images/" . $this->chronik->generateToken($file->getClientFilename()) . "." . $extension;
                $file->moveTo(__DIR__ . "/../../public/" . $filename);

                $this->chronik->posten($filename, $text, $currentUser, $currentuserid);
            }else{
                $err_message = "Leider kann Dein Bild nicht hochgeladen werden. 
                Vermutlich ist es zu groß oder entspricht keinem gängigem Format. Bitte probier eine andere Datei!";
            }
        }

        $cats = $this->chronik->anzeigenalle();

        return $this->view->render($response, 'chronik.html.twig',
        [
            'cats' => $cats,
            'error' => $err_message
        ]);
    }

    public function postLoeschen(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getParam('id');
        $success = $this->chronik->loeschen($id);

        if(!$success){
            $message = "Dein CATpost konnte leider nicht gelöscht werden. Bitte probiere es erneut.";
        }else{
            $message = "Dein CATpost wurde erfolgreich gelöscht!";
        }

        $cats = $this->chronik->anzeigeneigene();

        return $this->view->render($response, 'dashboard.twig',
        [
            'success' => $success,
            'message' => $message,
            'cats' => $cats
        ]);
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

    public function postBearbeiten(ServerRequestInterface $request, ResponseInterface $response)
    {
        $id = $request->getParam('id');
        $text = $request->getParam('text');
        $success = $this->chronik->bearbeiten($id, $text);

        if (!$success)
        {
            $message = "Dein CATpost konnte leider nicht gespeichert werden. Bitte probiere es erneut.";
        }
        else
        {
            $message = "Dein CATpost wurde erfolgreich geändert!";
        }

        return $this->view->render(
            $response,
            'dashboard.twig',
            [
                'success' => $success,
                'message' => $message
            ]
        );
    }


}