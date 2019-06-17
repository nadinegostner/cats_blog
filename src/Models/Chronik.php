<?php


namespace App\Models;

use RedBeanPHP\R;


class Chronik
{

    public function generateToken($input = "")
    {
        return hash("sha256", $input . time());
    }

    public function posten($locatoin ,$text ,$user )
    {
        $post = R::dispense('posts');
        $post->file = $locatoin;
        $post->text = $text;
        $post->user = $user;

        R::store($post);
    }

    public function anzeigenalle()
    {
        $cats = R::getAll("SELECT file, text FROM posts");
        return $cats;

    }

    public function anzeigeneigene()
    {
        $currentUser = $_SESSION['username'];
        $catsown = R::getAll("SELECT file, text FROM posts WHERE user ='$currentUser';");
        return $catsown;
    }



}