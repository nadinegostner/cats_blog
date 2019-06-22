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
       // $user = R::getCell("SELECT password FROM user WHERE username='$username'");

        $user = R::findOne("user", "username = ?", [$username]);
        //$passwordhash = R::getCell("SELECT password FROM user WHERE username='$username'");

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
        //$userexists = "SELECT * FROM user WHERE username='$username'";
        //$user = R::exec($userexists);

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

    public function updateUser($username,$password, $firstName, $lastName, $email )
    {
        $currentuser = $_SESSION["id"];
        //$newpassword = password_hash($passwort, PASSWORD_DEFAULT);

        //$updateQuery = "UPDATE user SET username='$username', password='$newpassword', first_name='$firstName', last_name='$lastName', email='$email' WHERE id='$currentuser'";

        //R::exec($updateQuery);

       // R::exec("UPDATE user SET username='$username', password='$newpassword', first_name='$firstname', last_name='$lastname', email='$email' WHERE id='$currentuser'");

       // $id = R::getCell("SELECT id FROM user WHERE username='$currentuser'");

        $user = R::load('user', $currentuser);

        $user->username = $username;
        if($password != null) {
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        }
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->email = $email;

        R::store($user);

        //$2y$10$C1U34KbJFZBmUWFpt6pYquS2Yt6DsjeLUfAn6XiAn.rNxCWmrnDEa
        //$2y$10$PaLb2BO/N3lOR86ete928uxnWUUsMuMfIEhqR8moIcS0g2Lsm5rYO




    }
}