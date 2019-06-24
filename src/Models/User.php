<?php

namespace App\Models;

use RedBeanPHP\R;

class User
{
    public function createUser($username, $password, $firstName, $lastName, $email)
    {
        $user = R::dispense("user");

        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->email = $email;

        R::store($user);

        return $user;
    }

    public function login($username, $password)
    {
        $user = R::findOne("user", "username = ?", [$username]);

        if ($user && password_verify($password, $user->password))
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    public function exists($username)
    {

        $user = R::findOne("user", "username = ?", [$username]);

        if ($user != null)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function userAnzeigen()
    {
        $currentuser = $_SESSION['username'];

        $userprofile = R::findOne("user", "username = ?", [$currentuser]);

        return $userprofile;
    }

    public function updateUser($username, $firstName, $lastName, $email )
    {
        $currentuser = $_SESSION["id"];

        $user = R::load('user', $currentuser);

        $user->username = $username;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;

        R::store($user);

    }

    public function updatePW($password, $userid)
    {
        $user = R::load('user', $userid);

        $user->password = password_hash($password, PASSWORD_DEFAULT);

        R::store($user);
    }
}