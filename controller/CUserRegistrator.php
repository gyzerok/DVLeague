<?php
include ('..\model\MUser.php');

class CUserRegistrator
{
    static function  Register($userName, $userPass)
    {
        $user = new MUser(); $user->Init($userName, $userPass);
        $user->Insert();
    }
}
?>
