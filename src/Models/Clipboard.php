<?php

namespace App\Models;

use RedBeanPHP\R;

class Clipboard
{
    public function generateToken($input = "")
    {
        return hash("sha256", $input . time());
    }

    public function add($content, $selectedUsers = null, $type = "text", $token = false)
    {
        $clipboard = R::dispense('clipboard');
        $clipboard->token = $this->generateToken($content);
        $clipboard->content = $content;
        $clipboard->type = $type;

        if($selectedUsers)
        {
            foreach ($selectedUsers as $key => $username)
            {
                $user = R::dispense('clipboarduser');
                $user->username = $username;
                $clipboard->ownClipboarduserList[] = $user;
            }
        }
       

        R::store($clipboard);

        return $clipboard->token;
    }

    public function get($token)
    {
        $clipboard = R::findOne('clipboard', 'token = ?', [$token]);

        if ($clipboard) {
            //R::trash($clipboard);
            return $clipboard;
        } else {
            return false;
        }
    }

    public function delete($token) {

        $clipboard = R::findOne('clipboard', 'token = ?', [$token]);

        if ($clipboard) {
            R::trash($clipboard);
        } else {
            return false;
        }
    }

    public function deleteClipboarduser($username) {
        $clipboarduser = R::findOne('clipboarduser', 'username = ?', [$username]);

        if ($clipboarduser) {
            R::trash($clipboarduser);
        } else {
            return false;
        }
    }

}










