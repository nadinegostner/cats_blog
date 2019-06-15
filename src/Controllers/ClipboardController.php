<?php

namespace App\Controllers;

use App\Models\Clipboard;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ClipboardController
{
    protected $view;
    protected $clipboard;

    public function __construct(Twig $view, Clipboard $clipboard)
    {
        $this->view = $view;
        $this->clipboard = $clipboard;
    }

    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'chronik.twig');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        $files = $request->getUploadedFiles();

        if ($files && isset($files['image'])) {
            $file = $files['image'];

            if ($file->getError() === UPLOAD_ERR_OK) {
                $extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
                $filename = "images/" . $this->clipboard->generateToken($file->getClientFilename()) . "." . $extension;
                $file->moveTo(__DIR__ . "/../../public/" . $filename);
                $token = $this->clipboard->add($filename, null, "image");
            }
        } else {
            $data = $request->getParsedBody();
            if(count($data['users'])!=0){
                $token = $this->clipboard->add($data['content'], $data['users']);
            } else {
                $token = $this->clipboard->add($data['content']);
            }
        }

        $scheme = $request->getUri()->getScheme();
        $host = $request->getUri()->getHost() . ":" . $request->getUri()->getPort();

        return $this->view->render($response, 'newsletter.twig', [
            'uri' => $scheme . "://" . $host . "/clipboard/" . $token
        ]);
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $currentUser = $_SESSION['username'];
        $clipboard = $this->clipboard->get($args['token']);
        if ($clipboard)
        {
            $users = $clipboard->ownClipboarduserList;
            $authorized = false;

            if(count($users)!=0)
            {
                foreach ($users as $user)
                {
                    if($user->username == $currentUser || $user->username == "")
                    {
                        $this->clipboard->deleteClipboarduser($currentUser);
                        if(count($users) == 1)
                        {
                            $this->clipboard->delete($args['token']);
                        }
                        $authorized = true;
                    }
                }
            }
            else
            {
                $authorized = true;
            }
            
            
            return $this->view->render($response, 'dashboard.twig', [
                'authorized' => $authorized,
                'content' => $clipboard->content ,
                'token'   => $clipboard->token ,
                'type'    => $clipboard->type
            ]);
        } else {
            return $response
                ->withStatus(301)
                ->withHeader("Location", "/");
        }
    }
}