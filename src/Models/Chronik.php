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
        $cats = R::getAll("SELECT * FROM posts");
        return $cats;

    }

    public function anzeigeneigene()
    {
        $currentUser = $_SESSION['username'];
        $catsown = R::getAll("SELECT * FROM posts WHERE user ='$currentUser';");
        return $catsown;
    }

    public function loeschen($id){
        $post = R::load('posts', $id);
        R::trash($post);

        return true;
    }

    public function bearbeiten($id, $text){
        $post = R::load('posts', $id);
        $post->text = $text;

        R::store($post);

        $post = $post->fresh();

        return $post;
    }



}