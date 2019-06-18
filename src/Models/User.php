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

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }

    public function exists($username) {
        $user = R::findOne("user", "username = ?", [$username]);

        if ($user) {
            return true;
        }

        return false;
    }

    public function userAnzeigen()
    {
        $currentuser = $_SESSION['username'];

        $userprofile = R::findOne("user", "username = ?", [$currentuser]);

        return $userprofile;
    }

    public function updateUser()
    {

    }
}