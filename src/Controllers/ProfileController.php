<?php


namespace App\Controllers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use App\Models\User;


class ProfileController
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
        $sesid = $_SESSION["id"];

        return $this->view->render($response, 'profile.twig',
            [
                'userid' => $userprofile->id,
                'username' => $userprofile->username,
                'firstname' => $userprofile->first_name,
                'lastname' => $userprofile->last_name,
                'email' => $userprofile->email,
                'sesid' => $sesid

        ]);
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {

        // if ($request->isPost() && $request->getParam('username') && $request->getParam('password') && $request->getParam('passwordRepeat') && $request->getParam('firstName') && $request->getParam('lastName') && $request->getParam('email')) {

            $username = $request->getParam('username');
            $firstName = $request->getParam('firstName');
            $lastName = $request->getParam('lastName');
            $email = $request->getParam('email');
            $password = $request->getParam('password');
            $passwordRepeat = $request->getParam('passwordRepeat');

            if ($password == $passwordRepeat )
            {
                if($this->user->exists($username) == false)
                {
                    $this->user->updateUser($username, $password, $firstName, $lastName, $email);

                    return $response->withRedirect("/login");
                }
                else
                {
                    return $this->view->render($response, 'profile.twig', array("updateError" => "Der angegebene Benutzername existiert bereits"));
                }

            }
            else
            {
                return $this->view->render($response, 'profile.twig', array("updateError" => "Die angegebenen Passwörter stimmen nicht überein, versuchen Sie es erneut!"));
            }

        }


    //}

}