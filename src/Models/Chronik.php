<?php


namespace App\Models;

use RedBeanPHP\R;


class Chronik
{

    public function generateToken($input = "")
    {
        return hash("sha256", $input . time());
    }

    public function posten($locatoin ,$text ,$user, $userid)
    {
        $post = R::dispense('posts');
        $post->file = $locatoin;
        $post->text = $text;
        $post->user = $user;
        $post->userid = $userid;


        R::store($post);
    }

    public function anzeigenalle()
    {
        $cats = R::getAll("SELECT * FROM posts ORDER BY id DESC");
        return $cats;

    }

    public function editanzeigen($id){
        $cats = R::getAll("SELECT * FROM posts WHERE id='$id';");
        return $cats;
    }

    public function anzeigeneigene()
    {
        //$currentUser = $_SESSION['username'];
        $currentUserid = $_SESSION['id'];
        $catsown = R::getAll("SELECT * FROM posts WHERE userid ='$currentUserid' ORDER BY id DESC");
        return $catsown;
    }

    public function loeschen($id)
    {
        $post = R::load('posts', $id);
        R::trash($post);

        return true;
    }

    public function bearbeiten($id, $text)
    {
        $post = R::load('posts', $id);
        $post->text = $text;

        R::store($post);

        $post = $post->fresh();

        return $post;
    }



}